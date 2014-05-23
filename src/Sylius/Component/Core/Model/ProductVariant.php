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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Product\Model\Variant as BaseVariant;
use Sylius\Component\Variation\Model\VariantInterface as BaseVariantInterface;
use JMS\Serializer\Annotation as Serializer;

/**
 * Sylius core product variant entity.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 *
 * @Serializer\ExclusionPolicy("all")
 */
class ProductVariant extends BaseVariant implements ProductVariantInterface
{
    /**
     * Variant SKU.
     *
     * @var string
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    protected $sku;

    /**
     * The variant prices.
     *
     * @var ProductVariantPrice[]
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<Sylius\Component\Core\Model\ProductVariantPrice>")
     */
    protected $prices;

    /**
     * On hold.
     *
     * @var integer
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    protected $onHold = 0;

    /**
     * On hand stock.
     *
     * @var integer
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    protected $onHand = 0;

    /**
     * Is variant available on demand?
     *
     * @var Boolean
     *
     * @Serializer\Expose
     * @Serializer\Type("boolean")
     */
    protected $availableOnDemand = true;

    /**
     * Images.
     *
     * @var Collection|VariantImageInterface[]
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<Sylius\Component\Core\Model\ProductVariantImage>")
     */
    protected $images;

    /**
     * Weight.
     *
     * @var float
     *
     * @Serializer\Expose
     * @Serializer\Type("double")
     */
    protected $weight;

    /**
     * Width.
     *
     * @var float
     *
     * @Serializer\Expose
     * @Serializer\Type("double")
     */
    protected $width;

    /**
     * Height.
     *
     * @var float
     *
     * @Serializer\Expose
     * @Serializer\Type("double")
     */
    protected $height;

    /**
     * Depth.
     *
     * @var float
     *
     * @Serializer\Expose
     * @Serializer\Type("double")
     */
    protected $depth;

    /**
     * Override constructor to set on hand stock.
     */
    public function __construct()
    {
        parent::__construct();

        $this->images = new ArrayCollection();
        $this->prices = new ArrayCollection();
    }

    public function __toString()
    {
        $string = $this->getProduct()->getName();

        if (!$this->getOptions()->isEmpty()) {
            $string .= '(';

            foreach ($this->getOptions() as $option) {
                $string .= $option->getOption()->getName(). ': '.$option->getValue().', ';
            }

            $string = substr($string, 0, -2).')';
        }

        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * {@inheritdoc}
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @param PriceInterface $price
     */
    public function addPrice(PriceInterface $price)
    {
        if (!$this->prices->contains($price)) {
            $this->prices->add($price);
        }
        $price->setVariant($this);
    }

    /**
     * @param PriceInterface $price
     */
    public function removePrice(PriceInterface $price)
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
        }
    }

    /**
     * @param \ArrayAccess $prices
     * @return $this
     */
    public function setPrices($prices)
    {
        foreach ($prices as $price) {
            $this->addPrice($price);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isInStock()
    {
        return 0 < $this->onHand;
    }

    /**
     * {@inheritdoc}
     */
    public function getOnHold()
    {
        return $this->onHold;
    }

    /**
     * {@inheritdoc}
     */
    public function setOnHold($onHold)
    {
        $this->onHold = $onHold;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOnHand()
    {
        return $this->onHand;
    }

    /**
     * {@inheritdoc}
     */
    public function setOnHand($onHand)
    {
        $this->onHand = $onHand;

        if (0 > $this->onHand) {
            $this->onHand = 0;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getInventoryName()
    {
        return $this->getProduct()->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailableOnDemand()
    {
        return $this->availableOnDemand;
    }

    /**
     * {@inheritdoc}
     */
    public function setAvailableOnDemand($availableOnDemand)
    {
        $this->availableOnDemand = (Boolean) $availableOnDemand;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaults(BaseVariantInterface $masterVariant)
    {
        parent::setDefaults($masterVariant);

        $this->setPrices($masterVariant->getPrices());

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCategory()
    {
        return $this->getProduct()->getShippingCategory();
    }

    /**
     * {@inheritdoc}
     */
    public function hasImage(ProductVariantImageInterface $image)
    {
        return $this->images->contains($image);
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * {@inheritdoc}
     */
    public function addImage(ProductVariantImageInterface $image)
    {
        if (!$this->hasImage($image)) {
            $image->setVariant($this);
            $this->images->add($image);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeImage(ProductVariantImageInterface $image)
    {
        $image->setVariant(null);
        $this->images->removeElement($image);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * {@inheritdoc}
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * {@inheritdoc}
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * {@inheritdoc}
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingWeight()
    {
        return $this->getWeight();
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingWidth()
    {
        return $this->getWidth();
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingHeight()
    {
        return $this->getHeight();
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingDepth()
    {
        return $this->getDepth();
    }
}
