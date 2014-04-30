<?php

namespace Sylius\Bundle\CoreBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Shipping\Model\ShipmentStateInterface;

/**
 * Class ShipmentStateInitializer
 *
 * @package Sylius\Bundle\CoreBundle\EventListener
 */
class ShipmentStateInitializer
{
    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        if (!($shipment = $args->getEntity()) instanceof ShipmentInterface) {
            return;
        }

        $em = $args->getEntityManager();

        // init shipment state
        $state = $em->getRepository('Sylius\Component\Shipping\Model\ShipmentState')
                    ->findOneBy(['name' => ShipmentStateInterface::CHECKOUT]);
        $shipment->setState($state);
    }
}
