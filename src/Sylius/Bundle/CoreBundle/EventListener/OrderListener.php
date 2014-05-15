<?php


namespace Sylius\Bundle\CoreBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Payment\Model\PaymentStateInterface;
use Sylius\Component\Core\Model\OrderShippingStateInterface;

/**
 * Class OrderListener
 *
 * @package Sylius\Bundle\CoreBundle\EventListener
 */
class OrderListener
{
    public function prePersist(LifecycleEventArgs $args)
    {
        if (!($order = $args->getEntity()) instanceof OrderInterface) {
            return;
        }

        $em = $args->getEntityManager();

        // init payment state if it's null
        if (is_null($order->getPaymentState())) {
            $paymentState = $em->getRepository('Sylius\Component\Payment\Model\PaymentState')
                               ->findOneBy(['name' => PaymentStateInterface::CREATED]);
            $order->setPaymentState($paymentState);
        }

        // init shipping state if it's null
        if (is_null($order->getShippingState())) {
            $shippingState = $em->getRepository('Sylius\Component\Core\Model\OrderShippingState')
                                ->findOneBy(['name' => OrderShippingStateInterface::CHECKOUT]);
            $order->setShippingState($shippingState);
        }
    }
}