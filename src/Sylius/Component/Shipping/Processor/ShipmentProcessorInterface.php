<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Shipping\Processor;

use Sylius\Component\Shipping\Model\ShipmentState;
use Sylius\Component\Shipping\Model\ShipmentInterface;
use Sylius\Component\Shipping\Model\ShipmentItemInterface;

/**
 * Shipment processor.
 *
 * @author Saša Stamenković <umpirsky@gmail.com>
 */
interface ShipmentProcessorInterface
{
    /**
     * Update shipments state.
     *
     * @param ShipmentInterface[] $shipments
     * @param string              $stateTo   ShipmentState::*
     * @param string              $stateFrom ShipmentState::*
     */
    public function updateShipmentStates($shipments, $stateTo, $stateFrom = null);

    /**
     * Update shipment items shipment state.
     *
     * @param ShipmentItemInterface[] $items
     * @param string                  $stateTo   ShipmentState::*
     * @param string                  $stateFrom ShipmentState::*
     */
    public function updateItemStates($items, $stateTo, $stateFrom = null);
}
