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
 * Default order shipping states.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class OrderShippingStates
{
    const CHECKOUT          = 'checkout';
    const ONHOLD            = 'onhold';
    const READY             = 'ready';
    const BACKORDER         = 'backorder';
    const PARTIALLY_SHIPPED = 'partially_shipped';
    const SHIPPED           = 'shipped';
    const RETURNED          = 'returned';
    const CANCELLED         = 'cancelled';


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
     * @var Payment[]
     */
    protected $payments;


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
     * @param \Sylius\Component\Payment\Model\Payment[] $payments
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;
    }

    /**
     * @return \Sylius\Component\Payment\Model\Payment[]
     */
    public function getPayments()
    {
        return $this->payments;
    }
}
