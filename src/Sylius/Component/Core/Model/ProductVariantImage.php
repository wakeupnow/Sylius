<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Core\Model;

use JMS\Serializer\Annotation as Serializer;

class ProductVariantImage extends Image implements ProductVariantImageInterface
{
    /**
     * The associated product variant.
     *
     * @var ProductVariantInterface
     *
     * @Serializer\Type("Sylius\Component\Core\Model\ProductVariant")
     */
    protected $variant;

    protected $image_type;

    /**
     * {@inheritdoc}
     */
    public function getVariant()
    {
        return $this->variant;
    }

    /**
     * {@inheritdoc}
     */
    public function setVariant(ProductVariantInterface $variant = null)
    {
        $this->variant = $variant;

        return $this;
    }

    public function getImageType()
    {
        return $this->image_type;
    }

    public function setImageType(ProductVariantImageType $image_type)
    {
        $this->image_type = $image_type;
        return $this;
    }
}
