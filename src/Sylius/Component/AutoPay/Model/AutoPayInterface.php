<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Wun
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\AutoPay\Model;

use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

/**
 * AutoPay Interface.
 *
 * @author Abdullah Kiser <kiser.bd@gmail.com>
 */
interface AutoPayInterface extends TimestampableInterface
{
    /**
     * Set the product for the AutoPay
     *
     * @param ProductInterface $product
     * 
     * @return ProductInterface
     */
    public function setProduct(ProductInterface $product);

    /**
     * Get the product for this AutoPay
     *
     * @return ProductInterface
     */
    public function getProduct();

    /**
     * Set the Order for this AutoPay
     *
     * @param OrderInterface $order
     *
     */
    public function setOrder(OrderInterface $order);

    /**
     * Get the Order of this AutoPay
     *
     * @return OrderInterface
     */
    public function getOrder();

    /**
     * Set the interval for this AutoPay
     *
     * @param Interval $interval
     */
    public function setInterval(Interval $interval);

    /**
     * Get the interval for this AutoPay
     *
     * @return Interval;
     */
    public function getInterval();

}
