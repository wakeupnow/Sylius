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
use Doctrine\Common\Persistence\ObjectRepository;

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
    private $orderShippingStateRepository;

    /**
     * @param ObjectRepository $orderShippingStateRepository
     */
    function __construct(ObjectRepository $orderShippingStateRepository)
    {
        $this->orderShippingStateRepository = $orderShippingStateRepository;
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
            $state = $this->orderShippingStateRepository->findOneBy(['name' => OrderShippingState::BACKORDER]);
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

        $state = $this->orderShippingStateRepository->findOneBy(compact('name'));

        return $state;
    }
}
