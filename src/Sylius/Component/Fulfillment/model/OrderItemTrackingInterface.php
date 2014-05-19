<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Fulfillment\Model;

//use Sylius\Component\Order\Model\OrderInterface;

/**
 * Cart model interface.
 * All driver cart entities or documents should implement this interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface OrderItemTrackingInterface
{
    /**
     * @return OrderItem
     */
    public function getOrderItem();

    /**
     * @param OrderItem $orderItem
     */
    public function setOrderItem($orderItem);

    /**
     * @param string $trackingNumber
     */
    public function setTrackingNumber($trackingNumber);

    /**
     * @return string
     */
    public function getTrackingNumber();

    /**
     * @param ShippingMethod $shippingMethod
     */
    public function setShippingMethod($shippingMethod);

    /**
     * @return ShippingMethod
     */
    public function getShippingMethod();
}
