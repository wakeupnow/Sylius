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
 * Interface OrderShippingStateInterface
 *
 * @package Sylius\Component\Core\Model
 */
interface OrderShippingStateInterface
{
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
     * @param \Sylius\Component\Order\Model\Order[] $orders
     */
    public function setOrders($orders);

    /**
     * @return \Sylius\Component\Order\Model\Order[]
     */
    public function getOrders();

    /**
     * @return array
     */
    public static function getNames();
}
