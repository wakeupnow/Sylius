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
 * Class PaymentStatus
 *
 * @package Sylius\Component\Payment\Model
 */
class PaymentState
{
    const CREATED    = 'new';
    const PENDING    = 'pending';
    const PROCESSING = 'processing';
    const COMPLETED  = 'completed';
    const FAILED     = 'failed';
    const CANCELLED  = 'cancelled';
    const VOID       = 'void';
    const REFUNDED   = 'refunded';
    const UNKNOWN    = 'unknown';

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
