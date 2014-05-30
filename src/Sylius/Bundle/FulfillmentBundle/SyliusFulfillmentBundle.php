<?php

namespace Sylius\Bundle\FulfillmentBundle;


use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SyliusFulfillmentBundle extends Bundle
{
    /**
     * Return array of currently supported database drivers.
     *
     * @return array
     */
    public static function getSupportedDrivers()
    {
        return array(
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'Sylius\Component\Fulfillment\Model\FileTypeInterface'              => 'sylius.model.file_type.class',
            'Sylius\Component\Fulfillment\Model\FulfillmentProviderInterface'   => 'sylius.model.fulfillment_provider.class',
            'Sylius\Component\Fulfillment\Model\OrderItemTrackingInterface'     => 'sylius.model.order_item_tracking.class',
            'Sylius\Component\Fulfillment\Model\ParameterTypeInterface'         => 'sylius.model.parameter_type.class',
            'Sylius\Component\Fulfillment\Model\ProtocolInterface'              => 'sylius.model.Protocol.class',
            'Sylius\Component\Fulfillment\Model\ProviderParameterInterface'     => 'sylius.model.provider_parameter.class',
            'Sylius\Component\Fulfillment\Model\FulfillmentInterface'           => 'sylius.model.fulfillment.class',

        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('sylius_fulfillment', $interfaces));

        $mappings = array(
            realpath(__DIR__.'/Resources/config/doctrine/model') => 'Sylius\Component\Fulfillment\Model',
        );

        $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, array('doctrine.orm.entity_manager'), 'sylius_fulfillment.driver.doctrine/orm'));
    }
}
