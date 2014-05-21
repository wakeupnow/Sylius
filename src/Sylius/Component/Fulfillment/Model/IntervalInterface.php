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
 * File Type model interface.
 * All file type entities or documents should implement this interface.
 *
 * @author Tony Rocha <tony.rocha@wakeupnow.com>
 */
interface IntervalInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param string $minute
     */
    public function setMinute($minute);

    /**
     * @return minute
     */
    public function getMinute();

    /**
     * @param string $hour
     */
    public function setHour($hour);

    /**
     * @return hour
     */
    public function getHour();

    /**
     * @param string $dayMonth
     */
    public function setDayMonth($dayMonth);

    /**
     * @return dayMonth
     */
    public function getDayMonth();

    /**
     * @param string $month
     */
    public function setMonth($month);

    /**
     * @return month
     */
    public function getMonth();

    /**
     * @param string $dayWeek
     */
    public function setDayWeek($dayWeek);

    /**
     * @return dayWeek
     */
    public function getDayWeek();
}
