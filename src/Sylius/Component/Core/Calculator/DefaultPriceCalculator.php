<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Core\Calculator;

use Sylius\Component\Core\Model\PriceableInterface;

/**
 * Default calculator simply returns the priceable price.
 *
 * @author Saša Stamenković <umpirsky@gmail.com>
 */
class DefaultPriceCalculator implements PriceCalculatorInterface
{
    public function calculate(PriceableInterface $priceable)
    {
        $amount = $priceable->getPrices();

        if ($amount instanceof \Doctrine\ORM\PersistentCollection) {
            $amount = $amount->toArray();
        }

        if (is_array($amount)) {
            if (count($amount)) {
                foreach ($amount as $price) {

                    /** @var \Sylius\Component\Core\Model\ProductVariantPriceInterface $price */
                    if ($price->getType() == 'MSRP') {
                        $amount = $price->getAmount();
                        break;
                    }
                }
            }
            else {
                $amount = 0;
            }
        }

        return $amount;
    }
}
