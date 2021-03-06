<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\CoreBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Sylius\Bundle\CoreBundle\DependencyInjection\Compiler\DoctrineSluggablePass;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Sylius core bundle.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SyliusCoreBundle extends Bundle
{
    public static function getSupportedDrivers()
    {
        return array(
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM
        );
    }

    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'Sylius\Component\Core\Model\UserInterface'                    => 'sylius.model.user.class',
            'Sylius\Component\Core\Model\GroupInterface'                   => 'sylius.model.group.class',
            'Sylius\Component\Core\Model\ProductVariantImageInterface'     => 'sylius.model.product_variant_image.class',
            'Sylius\Component\Core\Model\OrderShippingStateInterface'      => 'sylius.model.order_shipping_state.class',
            'Sylius\Component\Core\Model\PriceTypeInterface'               => 'sylius.model.price_type.class',
            'Sylius\Component\Core\Model\ProductVariantPriceInterface'     => 'sylius.model.product_variant_price.class',
            'Sylius\Component\Core\Model\ProductVariantImageTypeInterface' => 'sylius.model.product_variant_image_type.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('sylius_core', $interfaces));
        $container->addCompilerPass(new DoctrineSluggablePass());

        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Sylius\Component\Core\Model',
        );

        $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, array('doctrine.orm.entity_manager'), 'sylius_core.driver.doctrine/orm'));
    }
}
