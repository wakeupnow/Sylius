<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Order\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as Serializer;

/**
 * Model for order line items.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 *
 * @Serializer\ExclusionPolicy("all")
 */
class OrderItem implements OrderItemInterface
{
    /**
     * Item id.
     *
     * @var mixed
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    protected $id;

    /**
     * Order.
     *
     * @var OrderInterface
     */
    protected $order;

    /**
     * Quantity.
     *
     * @var integer
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    protected $quantity = 0;

    /**
     * Unit price.
     *
     * @var integer
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    protected $unitPrice = 0;

    /**
     * Total adjustments.
     *
     * @var Collection|AdjustmentInterface[]
     */
    protected $adjustments;

    /**
     * Adjustments total.
     *
     * @var integer
     */
    protected $adjustmentsTotal = 0;

    /**
     * Order item total.
     *
     * @var integer
     *
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    protected $total = 0;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->adjustments = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function setQuantity($quantity)
    {
        if (0 > $quantity) {
            throw new \OutOfRangeException('Quantity must be greater than 0.');
        }

        $this->quantity = $quantity;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrder(OrderInterface $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdjustments()
    {
        return $this->adjustments;
    }

    /**
     * {@inheritdoc}
     */
    public function addAdjustment(AdjustmentInterface $adjustment)
    {
        if (!$this->hasAdjustment($adjustment)) {
            $adjustment->setAdjustable($this);
            $this->adjustments->add($adjustment);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAdjustment(AdjustmentInterface $adjustment)
    {
        if ($this->hasAdjustment($adjustment)) {
            $adjustment->setAdjustable(null);
            $this->adjustments->removeElement($adjustment);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasAdjustment(AdjustmentInterface $adjustment)
    {
        return $this->adjustments->contains($adjustment);
    }

    /**
     * {@inheritdoc}
     */
    public function getAdjustmentsTotal()
    {
        return $this->adjustmentsTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function clearAdjustments()
    {
        return $this->adjustments->clear();
    }

    /**
     * {@inheritdoc}
     */
    public function calculateAdjustmentsTotal()
    {
        $this->adjustmentsTotal = 0;

        foreach ($this->adjustments as $adjustment) {
            if (!$adjustment->isNeutral()) {
                $this->adjustmentsTotal += $adjustment->getAmount();
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * {@inheritdoc}
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateTotal()
    {
        $this->determineUnitPrice();
        $this->calculateAdjustmentsTotal();

        $this->total = ($this->quantity * $this->unitPrice) + $this->adjustmentsTotal;

        if ($this->total < 0) {
            $this->total = 0;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function equals(OrderItemInterface $orderItem)
    {
        return $this === $orderItem;
    }

    /**
     * {@inheritdoc}
     */
    public function merge(OrderItemInterface $orderItem, $throwOnInvalid = true)
    {
        if ($throwOnInvalid && ! $orderItem->equals($this)) {
            throw new \RuntimeException('Given item cannot be merged.');
        }

        if ($this !== $orderItem) {
            $this->quantity += $orderItem->getQuantity();
        }

        return $this;
    }

    /**
     * @todo OMG $this->getOrder()->getUser()->getMember()->getType()->getId()
     *
     * @param null $accountTypeName
     */
    public function determineUnitPrice($accountTypeName = null)
    {
        if (is_null($accountTypeName)) {

            // MSRP is used by default
            $accountTypeName = 'MSRP';

            if (!is_null($this->getOrder())) {

                /** @var \Sylius\Component\Core\Model\User $user */
                if (!is_null($user = $this->getOrder()->getUser())) {
                    if (!is_null($member = $user->getMember())) {
                        if (!is_null($accountType = $member->getType())) {
                            $accountTypeName = $accountType->getName();
                        }
                    }
                }
            }
        }

        /** @var \Sylius\Component\Core\Model\ProductVariant $variant */
        $variant = $this->getVariant();
        foreach ($variant->getPrices() as $price) {
            foreach ($price->getAccountTypes() as $at) {
                if ($at->getName() == $accountTypeName) {
                    $this->unitPrice = $price->getAmount();
                }
            }
        }
    }
}
