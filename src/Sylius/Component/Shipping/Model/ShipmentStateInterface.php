<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Shipping\Model;

/**
 * Interface ShipmentStateInterface
 * @package Sylius\Component\Shipping\Model
 */
interface ShipmentStateInterface
{
    const CHECKOUT   = 'checkout';
    const ONHOLD     = 'onhold';
    const PENDING    = 'pending';
    const READY      = 'ready';
    const SHIPPED    = 'shipped';
    const RETURNED   = 'returned';
    const CANCELLED  = 'cancelled';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param \Sylius\Component\Shipping\Model\Shipment[] $shipments
     */
    public function setShipments($shipments);

    /**
     * @return \Sylius\Component\Shipping\Model\Shipment[]
     */
    public function getShipments();

    /**
     * @return array
     */
    public static function getNames();
}
