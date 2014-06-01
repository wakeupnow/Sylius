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
use Sylius\Component\Core\Model\UserInterface;
use JMS\Serializer\Annotation as Serializer;

/**
 * Model for carts.
 * All driver entities and documents should extend this class or implement
 * proper interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Cart extends Order implements CartInterface
{
    /**
     * User.
     *
     * @var UserInterface
     */
    protected $user;

    /**
     * Expiration time.
     *
     * @var \DateTime
     *
     * @Serializer\Groups({"CartBasics"})
     * @Serializer\Expose
     * @Serializer\Type("DateTime")
     */
    protected $expiresAt;

    /**
     * @var string A token is used to identify carts
     *
     * @Serializer\Groups({"CartBasics"})
     * @Serializer\Expose
     * @Serializer\Type("string")
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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
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
