<?php

namespace Sylius\Bundle\AutoPayBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Sylius\Bundle\ResourceBundle\DependencyInjection\AbstractResourceExtension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SyliusAutoPayExtension extends AbstractResourceExtension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {     
        list($config) = $this->configure($config, new Configuration(), $container, self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS| self::CONFIGURE_VALIDATORS);
        $classes = $config['classes'];
        $container->setParameter('sylius.model.auto_pay.class', $classes['autoPay']['model']);
        $container->setParameter('sylius.model.interval.class', $classes['interval']['model']);
    }
}
