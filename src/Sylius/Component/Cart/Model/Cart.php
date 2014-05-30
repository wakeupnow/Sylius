<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Cart\Model;

use Sylius\Component\Order\Model\Order;

/**
 * Model for carts.
 * All driver entities and documents should extend this class or implement
 * proper interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Cart extends Order implements CartInterface
{
    /**
     * Expiration time.
     *
     * @var \DateTime
     */
    protected $expiresAt;

    /**
     * @var string A token is used to identify carts
     */
    protected $token;

    /**
     * @param string $expiresIn http://php.net/manual/en/dateinterval.construct.php
     */
    public function __construct($expiresIn = 'P1D')
    {
        parent::__construct();

        $this->incrementExpiresAt($expiresIn);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return parent::getId();
    }

    /**
     * {@inheritdoc}
     */
    public function isExpired()
    {
        return $this->getExpiresAt() < new \DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setExpiresAt(\DateTime $expiresAt = null)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * {@inheritdoc}
     */
    public function incrementExpiresAt($intervalSpec)
    {
        $expiresAt = new \DateTime();
        $expiresAt->add(new \DateInterval($intervalSpec));

        $this->expiresAt = $expiresAt;

        return $this;
    }
}
