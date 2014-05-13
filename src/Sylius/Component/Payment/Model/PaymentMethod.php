<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Payment\Model;

/**
 * Class PaymentMethod
 * @package Sylius\Component\Payment\Model
 */
class PaymentMethod implements PaymentMethodInterface
{
    /**
     * Payments method identifier.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Method.
     *
     * @var string
     */
    protected $name;

    /**
     * @param $name
     */
    public function __construct($name = '')
    {
        $this->name = $name;
    }

    /**
     * @return mixed
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }
}
