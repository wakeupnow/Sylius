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
 * Class ShipmentState
 * @package Sylius\Component\Shipping\Model
 */
class ShipmentState implements ShipmentStateInterface
{
    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Shipment[]
     */
    protected $shipments;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \Sylius\Component\Shipping\Model\Shipment[] $shipments
     */
    public function setShipments($shipments)
    {
        $this->shipments = $shipments;
    }

    /**
     * @return \Sylius\Component\Shipping\Model\Shipment[]
     */
    public function getShipments()
    {
        return $this->shipments;
    }

    /**
     * @return array
     */
    public static function getNames()
    {
        return array(
            self::CHECKOUT,
            self::SHIPPED,
            self::PENDING,
            self::READY,
            self::RETURNED,
            self::CANCELLED,
        );
    }
}
