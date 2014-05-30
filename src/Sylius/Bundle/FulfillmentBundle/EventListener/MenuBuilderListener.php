<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Wun
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\FulfillmentBundle\EventListener;

use Sylius\Bundle\WebBundle\Event\MenuBuilderEvent;


/**
 * Fulfillment form type.
 *
 * @author Tony Rocha <tony.rocha@wakeupnow.com>
 */
class MenuBuilderListener
{
    public function addBackendMenuItems(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();

        $menu['configuration']->addChild('fulfillment_provider', array(
            'route' => 'sylius_backend_fulfillment_provider_index',
            'labelAttributes' => array('icon' => 'glyphicon glyphicon-cog'),
        ))->setLabel('sylius.form.fulfillment.fulfillment_providers');
    }
}