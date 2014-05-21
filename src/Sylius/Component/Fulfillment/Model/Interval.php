<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Fulfillment\Model;

/**
 * Model for File Types.
 * All driver entities and documents should extend this class or implement
 * proper interface.
 *
 * @author Tony Rocha <tony.rocha@wakeupnow.com>
 */
class Interval implements IntervalInterface
{
    /**
     * Id.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Minute.
     *
     * @var string
     */
    protected $minute;

    /**
     * Hour.
     *
     * @var string
     */
    protected $hour;

    /**
     * Day of the month.
     *
     * @var string
     */
    protected $dayMonth;

    /**
     * Month.
     *
     * @var string
     */
    protected $month;

    /**
     * Day of the week.
     *
     * @var string
     */
    protected $dayWeek;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $dayMonth
     */
    public function setDayMonth($dayMonth)
    {
        $this->dayMonth = $dayMonth;
    }

    /**
     * @return string
     */
    public function getDayMonth()
    {
        return $this->dayMonth;
    }

    /**
     * @param string $dayWeek
     */
    public function setDayWeek($dayWeek)
    {
        $this->dayWeek = $dayWeek;
    }

    /**
     * @return string
     */
    public function getDayWeek()
    {
        return $this->dayWeek;
    }

    /**
     * @param string $hour
     */
    public function setHour($hour)
    {
        $this->hour = $hour;
    }

    /**
     * @return string
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @param string $minute
     */
    public function setMinute($minute)
    {
        $this->minute = $minute;
    }

    /**
     * @return string
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * @param string $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }


}
