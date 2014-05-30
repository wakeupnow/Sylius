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
use Sylius\Component\AutoPay\Model\Interval;
use Sylius\Component\Fulfillment\Model\FileType;
use Sylius\Component\Fulfillment\Model\FulfillmentProviderInterface;
use Sylius\Component\Fulfillment\Model\Protocol;

/**
 * Default country fixtures.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadFulfillmentProviderData extends DataFixture
{
    private static $fulfillmentProviders = ['home_depot', 'wake_up_now', 'wayne_enterprises'];
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach (LoadFulfillmentProviderData::$fulfillmentProviders as $i => $providerName) {
            //$values = $this->getRandomProviderValues();

            /** @var FulfillmentProviderInterface $fulfillmentProvider */
            $fulfillmentProvider = $this
                ->getFulfillmentProviderRepository()
                ->createNew()
            ;
            $fulfillmentProvider->setName($providerName);

            $manager->persist($fulfillmentProvider);

            $this->setReference('Sylius.FulfillmentProvider.'.$i, $fulfillmentProvider);
        }
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /*private function getRandomProviderValues()
    {
        $res = [];

        $protocol = new Protocol();
        $protocol->setName('asdf');

        $interval = new Interval();
        $interval->setMinute('1');
        $interval->setHour('2');
        $interval->setDayMonth('3');
        $interval->setMonth('4');
        $interval->setDayWeek('5');

        $fileType = new FileType();
        $fileType->setName('qwer');

        $res[0] = $protocol;
        $res[1] = $interval;
        $res[2] = $fileType;

        return $res;

    }*/
}
