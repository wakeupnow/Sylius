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
use Sylius\Component\Fulfillment\Model\ProtocolInterface;

/**
 * Default country fixtures.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadProtocolData extends DataFixture
{
    protected static $protocols = ['ftp','api_call', 'smoke_signals'];
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach (LoadProtocolData::$protocols as $i => $protocolName) {
            /** @var ProtocolInterface $protocol */
            $protocol = $this
                ->getProtocolRepository()
                ->createNew()
            ;
            $protocol->setName($protocolName);
            $manager->persist($protocol);

            $this->setReference('Sylius.Protocol.'.$i, $protocol);
        }
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
