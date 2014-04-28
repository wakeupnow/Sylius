<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Component\Core\OrderProcessing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Doctrine\ORM\EntityManager;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderShippingState;
use Sylius\Component\Shipping\Model\ShipmentState;
use Sylius\Component\Core\Model\ShipmentInterface;

/**
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class StateResolverSpec extends ObjectBehavior
{
    function let(
        EntityManager $entityManager, $repo
    )
    {
        $repo->findOneBy(Argument::any())->willReturn(new OrderShippingState(OrderShippingState::BACKORDER));
        $entityManager->getRepository(Argument::any())->willReturn($repo);
        $this->beConstructedWith($entityManager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Component\Core\OrderProcessing\StateResolver');
    }

    function it_implements_Sylius_order_state_resolver_interface()
    {
        $this->shouldImplement('Sylius\Component\Core\OrderProcessing\StateResolverInterface');
    }

    function it_marks_order_as_a_backorders_if_it_contains_backordered_units(OrderInterface $order)
    {
        $order->isBackorder()->shouldBeCalled()->willReturn(true);

        $order->setShippingState(OrderShippingState::BACKORDER)->shouldBeCalled();
        $this->resolveShippingState($order);
    }

    function it_marks_order_as_shipped_if_all_shipments_devliered(
        OrderInterface $order,
        ShipmentInterface $shipment1,
        ShipmentInterface $shipment2
    )
    {
        $order->isBackorder()->shouldBeCalled()->willReturn(false);
        $order->getShipments()->willReturn(array($shipment1, $shipment2));

        $shipment1->getState()->willReturn(ShipmentState::SHIPPED);
        $shipment2->getState()->willReturn(ShipmentState::SHIPPED);

        $order->setShippingState(OrderShippingState::SHIPPED)->shouldBeCalled();
        $this->resolveShippingState($order);
    }

    function it_marks_order_as_partially_shipped_if_not_all_shipments_devliered(
        OrderInterface $order,
        ShipmentInterface $shipment1,
        ShipmentInterface $shipment2
    )
    {
        $order->isBackorder()->shouldBeCalled()->willReturn(false);
        $order->getShipments()->willReturn(array($shipment1, $shipment2));

        $shipment1->getState()->willReturn(ShipmentState::SHIPPED);
        $shipment2->getState()->willReturn(ShipmentState::READY);

        $order->setShippingState(OrderShippingState::PARTIALLY_SHIPPED)->shouldBeCalled();
        $this->resolveShippingState($order);
    }

    function it_marks_order_as_returned_if_all_shipments_were_returned(
        OrderInterface $order,
        ShipmentInterface $shipment1,
        ShipmentInterface $shipment2
    )
    {
        $order->isBackorder()->shouldBeCalled()->willReturn(false);
        $order->getShipments()->willReturn(array($shipment1, $shipment2));

        $shipment1->getState()->willReturn(ShipmentState::RETURNED);
        $shipment2->getState()->willReturn(ShipmentState::RETURNED);

        $order->setShippingState(OrderShippingState::RETURNED)->shouldBeCalled();
        $this->resolveShippingState($order);
    }
}
