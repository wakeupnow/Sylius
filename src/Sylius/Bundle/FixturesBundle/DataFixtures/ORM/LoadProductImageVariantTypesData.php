<?php

namespace Sylius\Bundle\FixturesBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Component\Core\Model\ProductVariantImageType;

class LoadProductImageVariantTypesData extends DataFixture
{
    public function load(ObjectManager $manager)
    {
        $types = array(
            'Thumbnail',
            'Medium',
            'Large',
            'Zoom',
            'Tier 1',
            'Tier 2',
            'Tier 3'
        );

        foreach ($types as $type) {
            $image_type = new ProductVariantImageType();
            $image_type->setName($type);

            $manager->persist($image_type);

            $this->setReference('Sylius.ProductImageVariantType.' . $type, $image_type);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}
