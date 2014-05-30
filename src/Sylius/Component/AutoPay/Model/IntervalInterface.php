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
interface IntervalInterface extends TimestampableInterface
{
    /**
     * Set Interval noOfDay
     *
     * @param integer $noOfDay
     */
    public function setNoOfDay($noOfDay);

    /**
     * Get the minute of the Interval
     *
     * @return integer
     */
    public function getNoOfDay();
}
