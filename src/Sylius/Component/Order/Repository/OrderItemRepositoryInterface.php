<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Order\Repository;

use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * Order repository interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface OrderItemRepositoryInterface extends RepositoryInterface
{
    /**
     * Get query builder for the form choice field.
     */
    public function getFormQueryBuilder();
}
