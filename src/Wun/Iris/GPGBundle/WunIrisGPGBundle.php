<?php

namespace Wun\Iris\GPGBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Wun\Iris\GPGBundle\DependencyInjection\Factory\Payment\GPGPaymentFactory;

class WunIrisGPGBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        /** @var $extension \Payum\Bundle\PayumBundle\DependencyInjection\PayumExtension */
        $extension = $container->getExtension('payum');

        $extension->addPaymentFactory(new GPGPaymentFactory);
    }
}
