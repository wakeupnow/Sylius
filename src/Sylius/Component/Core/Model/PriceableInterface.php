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
 * @author Saša Stamenković <umpirsky@gmail.com>
 */
interface PriceableInterface
{
    /**
     * Get the prices.
     *
     * @return PriceInterface
     */
    public function getPrices();

    /**
     * Set the prices.
     *
     * @param array $prices
     */
    public function setPrices(array $prices);
}
