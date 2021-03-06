<?php

namespace Sylius\Component\Core\Model;

/**
 * Class PriceType
 * @package Sylius\Component\Core\Model
 */
class PriceType implements PriceTypeInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @return int
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
     * @return array
     */
    public static function getNames()
    {
        return ['MSRP'];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
