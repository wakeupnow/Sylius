<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\FixturesBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * Sample payment gateways.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadPaymentGatewaysData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager->persist($this->createPaymentGateway('Dummy', 'dummy'));
        $manager->persist($this->createPaymentGateway('Paypal Express Checkout', 'paypal_express_checkout'));
        $manager->persist($this->createPaymentGateway('Stripe', 'stripe'));
        $manager->persist($this->createPaymentGateway('Be2bill', 'be2bill'));

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 4;
    }

    /**
     * Create payment gateway.
     *
     * @param string  $name
     * @param string  $gateway
     * @param Boolean $enabled
     *
     * @return PaymentGatewayInterface
     */
    protected function createPaymentGateway($name, $gateway, $enabled = true)
    {
        $method = $this
            ->getPaymentGatewayRepository()
            ->createNew()
        ;

        $method->setName($name);
        $method->setGateway($gateway);
        $method->setEnabled($enabled);

        $this->setReference('Sylius.PaymentGateway.'.$name, $method);

        return $method;
    }
}
