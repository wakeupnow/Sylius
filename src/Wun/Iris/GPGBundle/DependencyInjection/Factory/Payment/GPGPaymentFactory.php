<?php
namespace Wun\Iris\GPGBundle\DependencyInjection\Factory\Payment;

use Payum\Core\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Payum\Bundle\PayumBundle\DependencyInjection\Factory\Payment\AbstractPaymentFactory;

class GPGPaymentFactory extends AbstractPaymentFactory
{
    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $contextName, array $config)
    {
        if (false == class_exists('Wun\Iris\GPGBundle\Payum\PaymentFactory')) {
            throw new RuntimeException('Cannot find GPG payment factory class. Have you installed the package?');
        }

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../../../Resources/config/payment'));
        $loader->load('gpg.xml');

        return parent::create($container, $contextName, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gpg';
    }

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(ArrayNodeDefinition $builder)
    {
        parent::addConfiguration($builder);
        
        $builder->children()
            ->arrayNode('api')->isRequired()->children()
                ->scalarNode('client')->defaultValue('payum.buzz.client')->cannotBeEmpty()->end()
                ->arrayNode('options')->isRequired()->children()
                    ->scalarNode('apiusername')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('apipassword')->isRequired()->cannotBeEmpty()->end()
//                    ->scalarNode('clientid')->isRequired()->cannotBeEmpty()->end()
                    ->booleanNode('sandbox')->defaultTrue()->end()
                ->end()
            ->end()
        ->end();
    }

    /**
     * {@inheritDoc}
     */
    protected function addApis(Definition $paymentDefinition, ContainerBuilder $container, $contextName, array $config)
    {
        $apiDefinition = new DefinitionDecorator('payum.gpg.api');
        $apiDefinition->replaceArgument(0, new Reference($config['api']['client']));
        $apiDefinition->replaceArgument(1, $config['api']['options']);
        $apiDefinition->setPublic(true);
        $apiId = 'payum.context.'.$contextName.'.api';
        $container->setDefinition($apiId, $apiDefinition);
        $paymentDefinition->addMethodCall('addApi', array(new Reference($apiId)));
    }

    /**
     * {@inheritDoc}
     */
    protected function addActions(Definition $paymentDefinition, ContainerBuilder $container, $contextName, array $config)
    {
        $captureActionDefinition = new DefinitionDecorator('payum.gpg.action.capture');
        $captureActionId = 'payum.context.'.$contextName.'.action.capture';
        $container->setDefinition($captureActionId, $captureActionDefinition);
        $paymentDefinition->addMethodCall('addAction', array(new Reference($captureActionId)));

//        $captureOnsiteActionDefinition = new DefinitionDecorator('payum.gpg.action.capture_onsite');
//        $captureOnsiteActionId = 'payum.context.'.$contextName.'.action.capture_onsite';
//        $container->setDefinition($captureOnsiteActionId, $captureOnsiteActionDefinition);
//        $paymentDefinition->addMethodCall('addAction', array(new Reference($captureOnsiteActionId)));

        $statusActionDefinition = new DefinitionDecorator('payum.gpg.action.status');
        $statusActionId = 'payum.context.'.$contextName.'.action.status';
        $container->setDefinition($statusActionId, $statusActionDefinition);
        $paymentDefinition->addMethodCall('addAction', array(new Reference($statusActionId)));
    }
}