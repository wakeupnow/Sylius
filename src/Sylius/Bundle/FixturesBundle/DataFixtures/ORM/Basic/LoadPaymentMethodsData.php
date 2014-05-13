<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\FixturesBundle\DataFixtures\ORM\Basic;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Component\Payment\Model\PaymentMethodInterface;
use Sylius\Bundle\FixturesBundle\DataFixtures\ORM\DataFixture;

/**
 * Class LoadPaymentMethodsData
 * @package Sylius\Bundle\FixturesBundle\DataFixtures\ORM\Basic
 */
class LoadPaymentMethodsData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager->persist($card = $this->createPaymentMethod('Credit Card'));
        $manager->persist($this->createPaymentGateway($card, 'Propay', 'propay'));
        $manager->persist($this->createPaymentGateway($card, 'GPG', 'gpg'));

        $manager->persist($this->createPaymentMethod('Cash'));

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
     * @param string $name
     *
     * @return \Sylius\Component\Payment\Model\PaymentMethodInterface
     */
    protected function createPaymentMethod($name)
    {
        $method = $this
            ->getPaymentMethodRepository()
            ->createNew()
        ;

        $method->setName($name);

        return $method;
    }

    /**
     * Create payment gateway.
     *
     * @param PaymentMethodInterface  $paymentMethod
     * @param string  $name
     * @param string  $gateway
     * @param Boolean $enabled
     *
     * @return \Sylius\Component\Payment\Model\PaymentGatewayInterface
     */
    protected function createPaymentGateway(PaymentMethodInterface $paymentMethod, $name, $gateway, $enabled = true)
    {
        $entity = $this
            ->getPaymentGatewayRepository()
            ->createNew()
        ;

        $entity->setName($name);
        $entity->setGateway($gateway);
        $entity->setEnabled($enabled);
        $entity->setPaymentMethod($paymentMethod);

        $this->setReference('Sylius.PaymentGateway.' . $name, $entity);

        return $entity;
    }
}
