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
use Sylius\Component\Core\Model\PriceType;

class LoadPriceTypeData extends \Sylius\Bundle\FixturesBundle\DataFixtures\ORM\DataFixture
{
    public function load(ObjectManager $manager)
    {
        $names = PriceType::getNames();
        foreach ($names as $name) {
            $priceType = new PriceType();
            $priceType->setName($name);
            $manager->persist($priceType);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
