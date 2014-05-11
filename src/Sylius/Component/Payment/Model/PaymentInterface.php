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

use Sylius\Component\Resource\Model\TimestampableInterface;

/**
 * Single payment interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface PaymentInterface extends TimestampableInterface
{
    /**
     * Get payment gateway associated with this payment.
     *
     * @return PaymentMethodInterface
     */
    public function getMethod();

    /**
     * Set payment gateway.
     *
     * @param null|PaymentMethodInterface $method
     *
     * @return PaymentInterface
     */
    public function setMethod(PaymentMethodInterface $method = null);

    /**
     * Get payment source.
     *
     * @return PaymentSourceInterface
     */
    public function getSource();

    /**
     * Set payment source.
     *
     * @param null|PaymentSourceInterface $source
     *
     * @return PaymentInterface
     */
    public function setSource(PaymentSourceInterface $source = null);

    /**
     * Get state.
     *
     * @return PaymentState
     */
    public function getState();

    /**
     * Set state.
     *
     * @param PaymentState $state
     *
     * @return PaymentInterface
     */
    public function setState(PaymentState $state);

    /**
     * Get payment currency.
     *
     * @return string
     */
    public function getCurrency();

    /**
     * Set currency.
     *
     * @param string
     *
     * @return PaymentInterface
     */
    public function setCurrency($currency);

    /**
     * Get amount.
     *
     * @return integer
     */
    public function getAmount();

    /**
     * Set amount.
     *
     * @param integer $amount
     *
     * @return PaymentInterface
     */
    public function setAmount($amount);

    /**
     * @param array $details
     *
     * @return PaymentInterface
     */
    public function setDetails(array $details);

    /**
     * @return array
     */
    public function getDetails();
}
