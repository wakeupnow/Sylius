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
 * Interface PaymentStateInterface
 * @package Sylius\Component\Payment\Model
 */
interface PaymentStateInterface
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
     * @return mixed
     */
    public function getId();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param \Sylius\Component\Payment\Model\Payment[] $payments
     */
    public function setPayments($payments);

    /**
     * @return \Sylius\Component\Payment\Model\Payment[]
     */
    public function getPayments();
}
