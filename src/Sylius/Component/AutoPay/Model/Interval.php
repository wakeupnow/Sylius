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

use Sylius\Component\Resource\Model\TimestampableInterface;

/**
 * AutoPay Interface.
 *
 * @author Abdullah Kiser <kiser.bd@gmail.com>
 */

class Interval implements TimestampableInterface
{
    /**
     * AutoPay id.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Minute
     *
     * @var mixed
     */
    private $minute;

    /**
     * Hour
     *
     * @var mixed
     */
    private $hour;

    /**
     * Day Of month
     *
     * @var string
     */
    private $dayMonth;

    /**
     * Month
     *
     * @var string
     */
    private $month;

    /**
     * Day Of week
     *
     * @var string
     */
    private $dayWeek;

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
     * Set Interval minute
     *
     * @param string $minute
     */
    public function setMinute($minute)
    {
        $this->minute = $minute;
    }

    /**
     * Get the minute of the Interval
     *
     * @return string
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * Set the hour of Interval
     *
     * @param string $hour
     */
    public function setHour($hour)
    {
        $this->hour = $hour;
    }

    /**
     * Get the hour of Interval
     *
     * @return string
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * Set the day of the month of Interval
     *
     * @param string $dayMonth
     */
    public function setDayMonth($dayMonth)
    {
        $this->dayMonth = $dayMonth;
    }

    /**
     * Get the day of the month of Interval
     * @return string
     */
    public function getDayMonth()
    {
        return $this->dayMonth;
    }

    /**
     * Set the month of the Interval
     * @param string $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * Get the month of the Interval
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set the day of the week of Interval
     *
     * @param string $dayWeek
     */
    public function setDayWeek($dayWeek)
    {
        $this->dayWeek = $dayWeek;
    }

    /**
     * Get the day of the week of Interval
     *
     * @return string
     */
    public function getDayWeek()
    {
        return $this->dayWeek;
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