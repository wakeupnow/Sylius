<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\FulfillmentBundle\Controller;

use Doctrine\Common\Persistence\ObjectRepository;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Fulfillment Provider controller.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@sylius.pl>
 */
class FulfillmentProviderController extends ResourceController
{
    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        $fulfillment = parent::createNew();

        return $fulfillment;
    }

    /**
     * Get fulfillment repository.
     *
     * @return ObjectRepository
     */
    protected function getFulfillmentProviderRepository()
    {
        return $this->get('sylius.repository.fulfillment_provider');
    }
}
