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

/**
 * Model for Fulfillment Providers.
 * All driver entities and documents should extend this class or implement
 * proper interface.
 *
 * @author Tony Rocha <tony.rocha@wakeupnow.com>
 */
class OrderItemTracking implements OrderItemTrackingInterface
{
    /**
     * Id.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Order Item.
     *
     * @var OrderItem
     */
    protected $orderItem;

    /**
     * Tracking Number.
     *
     * @var string
     */
    protected $trackingNumber;

    /**
     * Shipping Method.
     *
     * @var int
     */
    protected $shippingMethod;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param OrderItem $orderItem
     */
    public function setOrderItem($orderItem)
    {
        $this->orderItem = $orderItem;
    }

    /**
     * @return OrderItem
     */
    public function getOrderItem()
    {
        return $this->orderItem;
    }

    /**
     * @param ShippingMethod $shippingMethod
     */
    public function setShippingMethod($shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;
    }

    /**
     * @return ShippingMethod
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     * @param string $trackingNumber
     */
    public function setTrackingNumber($trackingNumber)
    {
        $this->trackingNumber = $trackingNumber;
    }

    /**
     * @return string
     */
    public function getTrackingNumber()
    {
        return $this->trackingNumber;
    }
}
