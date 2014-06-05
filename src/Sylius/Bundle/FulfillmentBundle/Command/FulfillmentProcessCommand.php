<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\FulfillmentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Sylius\Bundle\FulfillmentBundle\Service\FulfillmentJobService;

//use Sylius\Component\AutoPay\Model\Interval;
//use Sylius\Component\Core\Model\Product;
//use Sylius\Component\Core\Model\OrderItem;
//use Sylius\Component\Core\Model\Order;
//use Sylius\Component\Core\Model\ProductVariant;
//use Sylius\Component\Shipping\Model\ShipmentState;

/**
 * Command to run fulfillment batch job
 *
 * @author Tony Rocha <tony.rocha@wakeupnow.com>
 */
class FulfillmentProcessCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sylius:fulfillment:process')
            ->setDescription('Executes fulfillment processing')
            ->addArgument('fp_ids', InputArgument::OPTIONAL, 'Comma separated list of fulfillment provider IDs to process.');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var FulfillmentJobService $jobClass */
        $jobClass = $this->getContainer()->get('sylius_fulfillment.fulfillment_job');
        $jobClass->execute([]);

        die;
    }

    /**
     * Determines whether or not an interval is eligible for fulfillment on today's date.
     *
     * @param Interval $interval
     *
     * @return boolean
     */

    private function getFulfillmentEligibility(Interval $interval)
    {
        $minute = date('i');
        $hour = date('g');
        $day_month = date('j');
        $day_week = (date('N') % 7) + 1 . ''; //Adjust day of the week such that 1 = Sun, 2 = Mon, etc.
        $month = date('n');

        $res = $this->isTimePartEqual($minute, $interval->getMinute())
            && $this->isTimePartEqual($hour, $interval->getHour())
            && $this->isTimePartEqual($day_month, $interval->getDayMonth())
            && $this->isTimePartEqual($day_week, $interval->getDayWeek())
            && $this->isTimePartEqual($month, $interval->getMonth())
        ;

        return $res;
    }

    /**
     * Returns whether the time part is equal to the interval part.
     * If the interval part is null or empty, it should return true.
     *
     * @param string $datePartValue
     * @param string $intervalPartValue
     *
     * @return boolean
     */
    private function isTimePartEqual($datePartValue, $intervalPartValue)
    {
        if($intervalPartValue == null)
        {
            return true;
        }
        else if(is_string($datePartValue) == true && is_string($intervalPartValue) == true)
        {
            $datePartValue = ltrim(trim($datePartValue), '0');
            $intervalPartValue = ltrim($intervalPartValue, '0');

            if($intervalPartValue == '')
            {
                return true;
            }

            if(strcmp($datePartValue,$intervalPartValue) == 0)
            {
                return true;
            }
        }
        else
        {
            //log?? in this case the parameters were not a string, nor null...unlikely scenario
        }
        return false;
    }
}