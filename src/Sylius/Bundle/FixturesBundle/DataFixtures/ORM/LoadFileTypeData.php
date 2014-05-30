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
use Sylius\Component\Fulfillment\Model\FileTypeInterface;

/**
 * Default country fixtures.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadFileTypeData extends DataFixture
{
    private static $fileTypes = ['xml','delimited', 'fixed_width'];
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {

        foreach (LoadFileTypeData::$fileTypes as $i => $fileTypeName) {
            /** @var FileTypeInterface $fileType */
            $fileType = $this
                ->getFileTypeRepository()
                ->createNew()
            ;
            $fileType->setName($fileTypeName);

            $manager->persist($fileType);

            $this->setReference('Sylius.FileType.'.$i, $fileType);
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
