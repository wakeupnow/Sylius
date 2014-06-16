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
 * Model for orders.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Order implements OrderInterface
{
    /**
     * Id.
     *
     * @var mixed
     *
     * @Serializer\Groups({"CartBasics"})
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    protected $id;

    /**
     * Completion time.
     *
     * @var \DateTime
     *
     * @Serializer\Expose
     * @Serializer\Type("DateTime")
     */
    protected $completedAt;

    /**
     * Order number.
     *
     * @var string
     *
     * @Serializer\Groups({"CartBasics"})
     * @Serializer\Expose
     * @Serializer\Type("string")
     */
    protected $number;

    /**
     * Items in order.
     *
     * @var
     * @var Collection|OrderItemInterface[]
     *
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<Sylius\Component\Core\Model\OrderItem>")
     */
    protected $items;

    /**
     * Items total.
     *
     * @var integer
     *
     * @Serializer\Groups({"CartBasics"})
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    protected $itemsTotal = 0;

    /**
     * Adjustments.
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
     * Calculated total.
     * Items total + adjustments total.
     *
     * @var integer
     *
     * @Serializer\Groups({"CartBasics"})
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    protected $total = 0;

    /**
     * Item CV Total.
     *
     * @var integer
     */
    protected $itemsCVTotal = 0;

    /**
     * CV Adjustments total.
     *
     * @var integer
     */
    protected $cvAdjustmentsTotal = 0;

    /**
     * CV total.
     *
     * @var integer
     */
    protected $cvTotal = 0;

    /**
     * Whether order was confirmed.
     *
     * @var Boolean
     *
     * @Serializer\Type("boolean")
     */
    protected $confirmed = true;

    /**
     * Confirmation token.
     *
     * @var string
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     */
    protected $confirmationToken;

    /**
     * Creation time.
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * Modification time.
     *
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * Deletion time.
     *
     * @var \DateTime
     */
    protected $deletedAt;

    /**
     * State
     *
     * @var integer
     */
    protected $state = OrderInterface::STATE_CART;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->adjustments = new ArrayCollection();
        $this->createdAt = new \DateTime();
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
    public function isCompleted()
    {
        return null !== $this->completedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function complete()
    {
        $this->completedAt = new \DateTime();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompletedAt()
    {
        return $this->completedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompletedAt(\DateTime $completedAt = null)
    {
        $this->completedAt = $completedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * {@inheritdoc}
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * {@inheritdoc}
     */
    public function setItems(Collection $items)
    {
        $this->items = $items;
        $this->calculateTotal();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function clearItems()
    {
        $this->items->clear();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function countItems()
    {
        return $this->items->count();
    }

    /**
     * {@inheritdoc}
     */
    public function addItem(OrderItemInterface $item)
    {
        if ($this->hasItem($item)) {
            return $this;
        }

        foreach ($this->items as $existingItem) {
            if ($item->equals($existingItem)) {
                $existingItem->merge($item, false);

                return $this;
            }
        }

        $item->setOrder($this);
        $this->items->add($item);

        $this->calculateTotal();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeItem(OrderItemInterface $item)
    {
        if ($this->hasItem($item)) {
            $item->setOrder(null);
            $this->items->removeElement($item);
        }

        $this->calculateTotal();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasItem(OrderItemInterface $item)
    {
        return $this->items->contains($item);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemsTotal()
    {
        return $this->itemsTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function setItemsTotal($itemsTotal)
    {
        $this->itemsTotal = $itemsTotal;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateItemsTotal()
    {
        $itemsTotal = 0;

        foreach ($this->items as $item) {
            $item->calculateTotal();

            $itemsTotal += $item->getTotal();
        }

        $this->itemsTotal = $itemsTotal;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateItemsCVTotal()
    {
        $itemsCVTotal = 0;

        foreach ($this->items as $item) {
            //$item->calculateCVTotal();

            $itemsCVTotal += $item->getCVTotal();
        }

        $this->itemsCVTotal = $itemsCVTotal;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateCVAdjustmentsTotal()
    {
        $cvAdjustmentsTotal = 0;

        foreach ($this->adjustments as $adjustment) {
            if (!$adjustment->isNeutral()) {
                $cvAdjustmentsTotal += $adjustment->getCV();
            }
        }

        $this->cvAdjustmentsTotal = $cvAdjustmentsTotal;
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
        $this->adjustments->clear();

        return $this;
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
        $this->calculateItemsTotal();
        $this->calculateAdjustmentsTotal();
        $this->calculateItemsCVTotal();
        $this->calculateCVAdjustmentsTotal();

        $this->total = $this->itemsTotal + $this->adjustmentsTotal;
        $this->cvTotal = $this->itemsCVTotal + $this->cvAdjustmentsTotal;

        if ($this->total < 0) {
            $this->total = 0;
        }

        if ($this->cvTotal < 0) {
            $this->cvTotal = 0;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getItemsCVTotal()
    {
        return $this->itemsCVTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function setItemsCVTotal($itemsCVTotal)
    {
        $this->itemsCVTotal = $itemsCVTotal;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCVAdjustmentsTotal()
    {
        return $this->cvAdjustmentsTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function getCVTotal()
    {
        return $this->cvTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function setCVTotal($cvTotal)
    {
        $this->cvTotal = $cvTotal;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isDeleted()
    {
        return null !== $this->deletedAt && new \DateTime() >= $this->deletedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setDeletedAt(\DateTime $deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalItems()
    {
        return $this->countItems(); /** @TODO: We may want to delete that */
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalQuantity()
    {
        $quantity = 0;

        foreach ($this->items as $item) {
            $quantity += $item->getQuantity();
        }

        return $quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return $this->items->isEmpty();
    }
}
