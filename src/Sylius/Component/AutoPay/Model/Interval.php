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

/**
 * AutoPay Interface.
 *
 * @author Abdullah Kiser <kiser.bd@gmail.com>
 */

class Interval implements IntervalInterface
{
    /**
     * AutoPay id.
     *
     * @var mixed
     */
    protected $id;

    /**
     * NoOfDay
     *
     * @var integer
     */
    private $noOfDay;    

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
    public function setNoOfDay($noOfDay)
    {
        $this->noOfDay = $noOfDay;
    }

    /**
     * {@inheritdoc}
     */
    public function getNoOfDay()
    {
        return $this->noOfDay;
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