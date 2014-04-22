<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\CoreBundle\EventListener;

use Sylius\Bundle\ResourceBundle\Exception\UnexpectedTypeException;
use Sylius\Component\Core\Model\InventoryUnitInterface;
use Sylius\Component\Shipping\Model\ShipmentState;
use Sylius\Component\Shipping\Model\ShipmentInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Inventory unit listener.
 *
 * @author Saša Stamenković <umpirsky@gmail.com>
 */
class InventoryUnitListener
{
    /**
     * Update inventory unit state.
     *
     * @param GenericEvent $event
     *
     * @throws \InvalidArgumentException
     */
    public function updateState(GenericEvent $event)
    {
        $unit = $this->getInventoryUnit($event);

        $state = $event->getArgument('state');

        $unit->setInventoryState($state);

        switch ($state) {
            case $unit::STATE_BACKORDERED:
                $unit->setShippingState(ShipmentState::ONHOLD);
                break;

            case $unit::STATE_SOLD:
                $unit->setShippingState(ShipmentState::READY);
                break;

            case $unit::STATE_RETURNED:
                $unit->setShippingState(ShipmentState::RETURNED);
                break;

            default:
                throw new \InvalidArgumentException(sprintf('Unexpected inventory state "%s".', $state));
        }
    }

    private function getInventoryUnit(GenericEvent $event)
    {
        $unit = $event->getSubject();

        if (!$unit instanceof InventoryUnitInterface) {
            throw new UnexpectedTypeException(
                $unit,
                'Sylius\Component\Core\Model\InventoryUnitInterface'
            );
        }

        return $unit;
    }
}
