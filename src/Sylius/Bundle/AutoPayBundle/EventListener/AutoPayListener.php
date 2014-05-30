<?php
/*
 * This file is part of the Sylius package.
 *
 * (c) Wun
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\AutoPayBundle\EventListener;

use Sylius\Component\Order\Model\OrderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Set an Order as completed
 *
 * @author Abdullah Kiser <kiser.bd@gmail.com>
 */

class AutoPayListener
{
    /** @var ContainerInterface */
    protected $container;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }
    
    public function initAutoPay(GenericEvent $event)
    {
        $order = $event->getSubject();        

        if (!$order instanceof OrderInterface) {
            throw new \InvalidArgumentException(sprintf(
                'Event subject must implement Sylius\\Bundle\\OrderBundle\\Model\\OrderInterface, %s given.',
                is_object($order) ? get_class($order) : gettype($order)
            ));
        }
        $autoPay = $this->container->get('sylius.auto_pay.manager');
        $autoPay->initAutoPayForProduct($order);
    }
}
