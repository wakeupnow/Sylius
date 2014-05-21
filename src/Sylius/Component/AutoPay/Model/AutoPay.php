<?php
/*
 * This file is part of the Sylius package.
 *
 * (c) Wun
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Sylius\Component\AutoPay\Model;

use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\OrderInterface;

/**
 * Default autopay model.
 *
 * @author Abdullah Kiser <kiser.bd@gmail.com>
 */

class AutoPay implements AutoPayInterface
{
    /**
     * AutoPay id.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Product in AutoPay
     *
     * @var ProductInterface
     */
    protected $product;

    /**
     * Order in AutoPay
     * 
     * @var OrderInterface 
     */
    protected $order;

    /**
     * Interval of the
     *
     * @var Interval 
     */
    protected $interval;

    /**
     * NextDate of AutoPay
     *
     * @var \DateTime
     */
    protected $nextDate;

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
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;
    }

    /**
     * {@inheritdoc}
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;
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
    public function setInterval(Interval $interval)
    {
        $this->interval = $interval;
    }

    /**
     * {@inheritdoc}
     */
    public function getInterval()
    {
        return $this->interval;
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
}
