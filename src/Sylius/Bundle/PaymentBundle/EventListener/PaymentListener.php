<?php

namespace Sylius\Bundle\PaymentBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Sylius\Component\Payment\Model\PaymentInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PaymentListener
 * @package Sylius\Bundle\PaymentBundle\EventListener
 */
class PaymentListener
{
    /**
     * @var
     */
    private $container;

    /**
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $payment = $event->getEntity();

        if ((!$payment instanceof PaymentInterface) || $payment->getCurrency()) {
            return;
        }

        /** @var \Sylius\Bundle\CoreBundle\Context\CurrencyContext $currencyContext */
        $currencyContext = $this->container->get('sylius.currency_context');
        $payment->setCurrency($currencyContext->getDefaultCurrency());
    }
}
