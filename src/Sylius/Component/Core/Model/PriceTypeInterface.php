<?php

namespace Sylius\Component\Core\Model;

/**
 * Interface PriceTypeInterface
 * @package Sylius\Component\Core\Model
 */
interface PriceTypeInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function __toString();
}
