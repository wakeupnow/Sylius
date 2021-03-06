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
 * Payments model.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Payment implements PaymentInterface
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
     * @var PaymentMethodInterface
     */
    protected $method;

    /**
     * Gateway.
     *
     * @var PaymentGatewayInterface
     */
    protected $gateway;

    /**
     * Currency.
     *
     * @var string
     */
    protected $currency;

    /**
     * Amount.
     *
     * @var integer
     */
    protected $amount = 0;

    /**
     * State.
     *
     * @var string
     */
    protected $state;

    /**
     * Credit card as a source.
     *
     * @var CreditCardInterface
     */
    protected $creditCard;

    /**
     * Creation date.
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * Last update time.
     *
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var array
     */
    protected $details = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * {@inheritdoc}
     */
    public function setMethod(PaymentMethodInterface $method = null)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param PaymentGatewayInterface $gateway
     * @return PaymentInterface
     */
    public function setGateway(PaymentGatewayInterface $gateway = null)
    {
        if ($gateway) {
            $this->gateway = [$gateway];
        }
        else {
            $this->gateway = null;
        }

        return $this;
    }

    /**
     * @return \Sylius\Component\Payment\Model\PaymentGatewayInterface
     */
    public function getGateway()
    {
        if ($this->gateway) {
            return $this->gateway[0];
        }

        return $this->gateway;
    }

    /**
     * {@inheritdoc}
     */
    public function setSource(PaymentSourceInterface $source = null)
    {
        if (null === $source) {
            $this->creditCard = null;
        }

        if ($source instanceof CreditCardInterface) {
            $this->creditCard = [$source];
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSource()
    {
        if (null !== $this->creditCard) {
            return $this->creditCard[0];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * {@inheritdoc}
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function setState(PaymentState $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDetails(array $details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDetails()
    {
        return $this->details;
    }
}
