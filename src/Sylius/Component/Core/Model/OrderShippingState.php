<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Core\Model;

/**
 * Class OrderShippingState
 *
 * @package Sylius\Component\Core\Model
 */
class OrderShippingState implements OrderShippingStateInterface
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
     * @var Order[]
     */
    protected $orders;


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
     * @param \Sylius\Component\Order\Model\Order[] $orders
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
    }

    /**
     * @return \Sylius\Component\Order\Model\Order[]
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @return array
     */
    public static function getNames()
    {
        return array(
            self::CHECKOUT,
            self::ONHOLD,
            self::READY,
            self::BACKORDER,
            self::PARTIALLY_SHIPPED,
            self::SHIPPED,
            self::RETURNED,
            self::CANCELLED,
        );
    }
}
