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

use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Core\Model\UserInterface;

/**
 * Cart model interface.
 * All driver cart entities or documents should implement this interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface CartInterface extends OrderInterface
{
    /**
     * Get the identifier.
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Gets expiration time.
     *
     * @return \DateTime
     */
    public function getExpiresAt();

    /**
     * Sets expiration time.
     *
     * @param \DateTime|null $expiresAt
     */
    public function setExpiresAt(\DateTime $expiresAt = null);

    /**
     * Bumps the expiration time.
     */
    public function incrementExpiresAt($intervalSpec);

    /**
     * Checks whether the cart is expired or not.
     *
     * @return Boolean
     */
    public function isExpired();

    /**
     * Set token for remote identification
     *
     * @param string $token
     */
    public function setToken($token);

    /**
     * Get token
     *
     * @return string
     */
    public function getToken();

    /**
     * {@inheritdoc}
     */
    public function getUser();

    /**
     * {@inheritdoc}
     */
    public function setUser(UserInterface $user);
}
