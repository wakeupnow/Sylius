<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Component\Shipping\Processor;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Doctrine\Common\Persistence\ObjectRepository;
use Sylius\Component\Shipping\Processor\ShipmentProcessor;
use Sylius\Component\Shipping\Model\ShipmentState;
use Sylius\Component\Shipping\Model\ShipmentInterface;
use Sylius\Component\Shipping\Model\ShipmentItemInterface;

/**
 * @author Saša Stamenković <umpirsky@gmail.com>
 */
class ShipmentProcessorSpec extends ObjectBehavior
{
    function let(ObjectRepository $shipmentStateRepository)
    {
        $this->beConstructedWith($shipmentStateRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Component\Shipping\Processor\ShipmentProcessor');
    }

    function it_implements_Sylius_shipment_processor_interface()
    {
        $this->shouldImplement('Sylius\Component\Shipping\Processor\ShipmentProcessorInterface');
    }

    function it_updates_shipment_states(
        ShipmentInterface $shipment,
        ShipmentItemInterface $item
    )
    {
        $shipment->getState()->shouldBeCalled()->willReturn(new ShipmentState(ShipmentState::READY));
        $shipment->setState(Argument::that(
            function($state) {
                return $state->is(ShipmentState::SHIPPED);
            }
        ))->shouldBeCalled();
        $shipment->getItems()->shouldBeCalled()->willReturn(array($item));

        $item->getShippingState()->shouldBeCalled()->willReturn(new ShipmentState(ShipmentState::READY));
        $item->setShippingState(Argument::that(
            function($state) {
                return $state->is(ShipmentState::SHIPPED);
            }
        ))->shouldBeCalled();

        $this->updateShipmentStates(
            array($shipment), new ShipmentState(ShipmentState::SHIPPED), new ShipmentState(ShipmentState::READY));
    }

    function it_does_not_update_shipment_states_if_state_from_does_not_match(
        ShipmentInterface $shipment,
        ShipmentItemInterface $item
    )
    {
        $shipment->getState()->shouldBeCalled()->willReturn(ShipmentState::SHIPPED);
        $shipment->setState(ShipmentState::SHIPPED)->shouldNotBeCalled();

        $item->getShippingState()->shouldNotBeCalled();
        $item->setShippingState(ShipmentState::SHIPPED)->shouldNotBeCalled();

        $this->updateShipmentStates(array($shipment), ShipmentState::SHIPPED, ShipmentState::READY);
    }

    function it_updates_item_states(ShipmentItemInterface $item)
    {
        $item->getShippingState()->shouldBeCalled()->willReturn(ShipmentState::READY);
        $item->setShippingState(ShipmentState::SHIPPED)->shouldBeCalled();

        $this->updateItemStates(array($item), ShipmentState::SHIPPED, ShipmentState::READY);
    }

    function it_does_not_update_item_states_if_state_from_does_not_match(ShipmentItemInterface $item)
    {
        $item->getShippingState()->shouldBeCalled()->willReturn(ShipmentState::SHIPPED);
        $item->setShippingState(ShipmentState::SHIPPED)->shouldNotBeCalled();

        $this->updateItemStates(array($item), ShipmentState::SHIPPED, ShipmentState::READY);
    }
}
