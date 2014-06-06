<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Wun
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\AutoPayBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Sylius\Bundle\AutoPayBundle\Doctrine\ORM\AutoPayRepository;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Payment\Model\PaymentInterface;
use Sylius\Component\Cart\SyliusCartEvents;
use Sylius\Component\Core\SyliusCheckoutEvents;
use Sylius\Component\Order\SyliusOrderEvents;
use Sylius\Component\AutoPay\SyliusAutoPayEvents;

/**
 * Command to release expired pending orders
 *
 * @author Abdullah Kiser <kiser.bd@gmail.com>
 */
class AutoPayManager {

    /** @var ContainerInterface */
    protected $container;
    protected $repository;
    protected $orderRepository;
    protected $orderItemRepository;
    /**
     * AutoPay manager.
     *
     * @var ObjectManager
     */
    protected $manager;

    /**
     *
     * @param ContainerInterface $container
     * @param ObjectManager $manager
     * @param AutoPayRepository $repository 
     */
    public function __construct(ContainerInterface $container, ObjectManager $manager, AutoPayRepository $repository)
    {
        $this->container = $container;
        $this->repository = $repository;
        $this->manager = $manager;
        $this->orderRepository = $this->getOrderRepository();
        $this->orderItemRepository = $this->getOrderItemRepository();
    }

    /**
     *
     * @param OrderInterface $order
     */
    public function initAutoPayForProduct(OrderInterface $order)
    {
        $orderItems = $order->getItems();
        $autopys = $this->repository->findBy(array('order' => $order));
        foreach ($orderItems as $orderItem) {
            $product = $orderItem->getProduct();
            if ($product->getMasterVariant()->isAutoPay()) {
                $interval = $product->getMasterVariant()->getInterval();

                $autoPay = $this->repository->createNew();
                $autoPay->setProduct($product);
                $autoPay->setOrder($order);
                $autoPay->setInterval($interval);
                $autoPay->setNextDate($this->_calculateNextDate($interval));

                $this->manager->persist($autoPay);
            }
        }

        $this->manager->flush();
    }

    /**
     *
     */
    public function placeAutoPayOrder()
    {
        $autoPays = $this->repository->getDueByDate(\date('Y-m-d'));
        $autoPayItems = array();
        
        foreach ($autoPays as $autoPay) {
            $order = $autoPay->getOrder();
            $product = $autoPay->getProduct();
            
            // Get the order items from order and the product of auto pay
            $autoPayItems[$order->getId()][] = $this->orderItemRepository->getItemByOrderAndProduct($order, $product);
        }

        // Merge the items as same next date within a order for same user under a single order
        foreach($autoPayItems as $id => $autoPayItem){
            $order = null;
            $items = array();
            foreach($autoPayItem as $item){
                $order = $item->getOrder();
                $items[] = $item;                
            }

            $newOrder = $this->createOrderForAutoPay($order, $items);
            $this->manager->persist($newOrder);
            $this->dispatchCheckoutEvent(SyliusAutoPayEvents::POST_CREATE, $newOrder);
            
            //TODO: There will have to adjust and call event listner for payment and its state after dont with cart system.
            //Call the payment process for gpg gateway
            $this->_processPayment($newOrder);
        }

        $this->manager->flush();
    }

    protected function createOrderForAutoPay(OrderInterface $order, array $items)
    {
        $shipments = $order->getShipments();
        $payment = $order->getPayment();
        $craditCard = $payment->getSource();
        $product = $autoPay->getProduct();
        
        $newOrder = $this->orderRepository->createNew();
        foreach ($items as $item) {
            $newOrder->addItem($item);
        }

        $newOrder = $this->createShipment($shipments);
        $newOrder->setCurrency($order->getCurrency());
        $newOrder->setUser($order->getUser());
        $newOrder->setShippingAddress($order->getShippingAddress());
        $newOrder->setBillingAddress($order->getBillingAddress());
        $newOrder->setCreatedAt(date('now'));

        $this->dispatchEvents($newOrder);

        $newOrder->calculateTotal();
        $newOrder->complete();
        $newOrder = $this->createPayment($payment, $newOrder);

        return $newOrder;
    }

    protected function createAutoPayPayment(OrderInterface $order)
    {
        $captureToken = $this->_processPayment($order);
        return new RedirectResponse($captureToken->getTargetUrl());
    }

    protected function _processPayment(OrderInterface $order)
    {        
        //TODO: This full thing have to revice after Cart system functionality done!

        $payment = $order->getPayment();
        $craditCard = $payment->getSource();

        $details = array(
            'APIUsername' => urlencode($apiusername),
            'APIPwd' => urlencode($apipassword),
            'ClientID' => urlencode($clientid),
            'Amount' => number_format($order->getTotal() / 100, 2),
            'EmployeeID' => urlencode("9999"),
            'SSNSSI' => urlencode("102354699"),
            'Description' => urlencode("Test Payment"),
            'Rundate' => urlencode("1/1/1901")
        );

        $payment->setDetails($details);
        $order->setPayment($payment);
        $captureToken = $this->getTokenFactory()->createCaptureToken(
                        $order->getPayment()->getGateway()->getGateway(),
                        $order,
                        'sylius_checkout_forward',
                        array('stepName' => 'purchase')
        );

        return $captureToken;
    }

    /**
     *
     * @param <type> $interval
     * @return date
     */
    protected function _calculateNextDate($interval)
    {
        $days = $interval->getNoOfDay();
        // Anything purchase after 25 will set autopay date as 25.
        $date = (\date('d') < '25') ? \date('d') : '25';
        $nextDate = mktime(0, 0, 0, \date("m"), $date + $days, \date("Y"));
        $nextDate = \date("Y-m-d", $nextDate);
        return $nextDate;
    }    

    protected function createShipment($shipments, OrderInterface $order)
    {
        foreach ($shipments as $shipment) {
            $order->addShipment($shipment);
        }
        return $order;
    }

    protected function createPayment($payment, OrderInterface $order)
    {
        $order->setPayment($payment);
        $this->get('event_dispatcher')->dispatch(SyliusCheckoutEvents::FINALIZE_PRE_COMPLETE, new GenericEvent($order));
        return $order;
    }

    /**
     * @return TokenFactory
     */
    protected function getTokenFactory()
    {
        return $this->container->get('payum.security.token_factory');
    }

    protected function getOrderRepository()
    {
        return $this->container->get('sylius.repository.order');
    }

    protected function getOrderItemRepository()
    {
        return $this->container->get('sylius.repository.orderItem');
    }


    //TODO: After done with cart system and have data for autopay this method have to make some adjustment.
//    protected function createPayment(OrderInterface $order)
//    {
//        /* @var $payment PaymentInterface */
//        $payment = $this->getPaymentRepository()->createNew();
//        $payment->setMethod($this->getPaymentMethodRepository()->findOneBy(['name' => 'Credit Card']));
//        $payment->setGateway($this->getReference('Sylius.PaymentGateway.GPG'));
//        $payment->setAmount($order->getTotal());
//        $payment->setCurrency($order->getCurrency());
//        $payment->setState($this->getPaymentState());
//
//        $order->setPayment($payment);
//
//        $this->get('event_dispatcher')->dispatch(SyliusCheckoutEvents::FINALIZE_PRE_COMPLETE, new GenericEvent($order));
//    }

    protected function getPaymentState()
    {
        static $paymentStates = null;
        $paymentStates or $paymentStates = $this->getPaymentStateRepository()->findAll();

        return $paymentStates[array_rand($paymentStates)];
    }

    protected function dispatchEvents($order)
    {
        $dispatcher = $this->container->get('event_dispatcher');
        
        $dispatcher->dispatch(SyliusCheckoutEvents::SHIPPING_PRE_COMPLETE, new GenericEvent($order));
        $dispatcher->dispatch(SyliusOrderEvents::PRE_CREATE, new GenericEvent($order));
    }

}
