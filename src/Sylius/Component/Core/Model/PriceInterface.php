<?php

namespace Sylius\Component\Core\Model;

/**
 * Interface PriceInterface
 * @package Sylius\Component\Core\Model
 */
interface PriceInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return float
     */
    public function getAmount();

    /**
     * @param float $amount
     */
    public function setAmount($amount);
}
