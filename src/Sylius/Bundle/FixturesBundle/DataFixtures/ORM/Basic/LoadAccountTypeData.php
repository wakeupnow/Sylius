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
use Wun\Shared\DomainModelsBundle\Entity\AccountType;

class LoadAccountTypeData extends \Sylius\Bundle\FixturesBundle\DataFixtures\ORM\DataFixture
{
    public function load(ObjectManager $manager)
    {
        $names = AccountType::getNames();
        foreach ($names as $name) {
            $accountType = new AccountType();
            $accountType->setName($name);

            $this->setReference('Sylius.AccountType.' . $name, $accountType);

            $manager->persist($accountType);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
