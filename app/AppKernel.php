<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Sylius\Bundle\CoreBundle\Kernel\SyliusKernel;

/**
 * Sylius kernel.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class AppKernel extends SyliusKernel
{
    public function registerBundles()
    {
        return array_merge(parent::registerBundles(), [
            new \Wun\Shared\DomainModelsBundle\WunSharedDomainModelsBundle(),
            new \Wun\Shared\DomainModelsOrmBundle\WunSharedDomainModelsOrmBundle(),
	        new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle(),
            new Sylius\Bundle\FulfillmentBundle\SyliusFulfillmentBundle()
        ]);
    }

}
