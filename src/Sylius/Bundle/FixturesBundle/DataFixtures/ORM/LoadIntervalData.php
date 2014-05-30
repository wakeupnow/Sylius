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

/**
 * Default country fixtures.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadIntervalData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 3; $i++) {
            $values = $this->getRandomIntervalValues();

            /** @var Interval $interval */

            $interval = $this
                ->getIntervalRepository()
                ->createNew()
            ;

            $interval->setMinute($values[0]);
            $interval->setHour($values[1]);
            $interval->setDayMonth($values[2]);
            $interval->setMonth($values[3]);
            $interval->setDayWeek($values[4]);
            $manager->persist($interval);

            $this->setReference('Sylius.Interval.'.$i, $interval);
        }
        $manager->flush();
    }

    /**
     * Returns random values for minute, hour, day of the month, month, day of the week
     *
     * @return Array
     */
    private function getRandomIntervalValues()
    {
        $res = [];
        $res[0] = rand(0, 60);
        $res[1] = rand(1, 12);
        $res[2] = rand(1, 25);
        $res[3] = rand(1, 12);
        $res[4] = rand(1, 7);

        return $res;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
