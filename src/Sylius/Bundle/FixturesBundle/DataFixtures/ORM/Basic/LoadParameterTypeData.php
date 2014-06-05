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
use Sylius\Bundle\FixturesBundle\DataFixtures\ORM\DataFixture;

/**
 * Class LoadPaymentMethodsData
 * @package Sylius\Bundle\FixturesBundle\DataFixtures\ORM\Basic
 */
class LoadParameterTypeData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager->persist($this->createParameterType('FulfillmentExportClass'));
        $manager->persist($this->createParameterType('FulfillmentExportFilePath'));
        $manager->persist($this->createParameterType('FulfillmentExportFtpPath'));
        $manager->persist($this->createParameterType('FulfillmentExportFtpUsername'));
        $manager->persist($this->createParameterType('FulfillmentExportFtpPassword'));
        $manager->persist($this->createParameterType('FulfillmentExportFtpDirectory'));
        //$manager->persist($this->createParameterType('Credit Card'));


        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * @param string $name
     *
     * @return \Sylius\Component\Fulfillment\Model\ParameterType
     */
    protected function createParameterType($name)
    {
        $var = $this
            ->getParameterTypeRepository()
            ->createNew()
        ;

        $var->setName($name);

        return $var;
    }
}
