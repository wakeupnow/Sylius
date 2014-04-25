<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Core\OrderProcessing;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderShippingState;
use Sylius\Component\Shipping\Model\ShipmentState;
use Doctrine\ORM\EntityManager;

/**
 * Order state resolver.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class StateResolver implements StateResolverInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function resolvePaymentState(OrderInterface $order)
    {
        $order->setPaymentState($order->getPayment()->getState());
    }

    /**
     * {@inheritdoc}
     */
    public function resolveShippingState(OrderInterface $order)
    {
        if ($order->isBackorder()) {
            $state = $this->em->getRepository('Sylius\Component\Core\Model\OrderShippingState')
                              ->findOneBy(['name' => OrderShippingState::BACKORDER]);
            $order->setShippingState($state);

            return;
        }

        $order->setShippingState($this->getShippingState($order));
    }

    protected function getShippingState(OrderInterface $order)
    {
        $states = array();

        foreach ($order->getShipments() as $shipment) {
            $states[] = $shipment->getState()->getName();
        }

        $states = array_unique($states);

        $acceptableStates = array(
            ShipmentState::CHECKOUT   => OrderShippingState::CHECKOUT,
            ShipmentState::ONHOLD     => OrderShippingState::ONHOLD,
            ShipmentState::READY      => OrderShippingState::READY,
            ShipmentState::SHIPPED    => OrderShippingState::SHIPPED,
            ShipmentState::RETURNED   => OrderShippingState::RETURNED,
            ShipmentState::CANCELLED  => OrderShippingState::CANCELLED,
        );

        $name = OrderShippingState::PARTIALLY_SHIPPED;
        foreach ($acceptableStates as $shipmentState => $orderState) {
            if (array($shipmentState) == $states) {
                $name = $orderState;
            }
        }

        $state = $this->em->getRepository('Sylius\Component\Core\Model\OrderShippingState')->findOneBy(compact('name'));

        return $state;
    }
}
