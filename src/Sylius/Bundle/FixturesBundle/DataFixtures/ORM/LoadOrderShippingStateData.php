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
use Sylius\Component\Core\Model\OrderShippingState;

class LoadOrderShippingStateData extends DataFixture
{
    public function load(ObjectManager $manager)
    {
        $names = OrderShippingState::getNames();
        foreach ($names as $name) {
            $state = new OrderShippingState();
            $state->setName($name);
            $manager->persist($state);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 6;
    }
}
