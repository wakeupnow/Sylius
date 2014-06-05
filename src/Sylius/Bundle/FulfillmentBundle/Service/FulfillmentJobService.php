<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\FulfillmentBundle\Service;

use Ddeboer\DataImport\Writer\CsvWriter;
use Ddeboer\DataImport\Writer\WriterInterface;
use Sylius\Component\AutoPay\Model\Interval;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Model\OrderItem;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Core\Model\ProductVariant;
use Sylius\Component\Shipping\Model\ShipmentState;

use Symfony\Component\Validator\Exception\MissingOptionsException;
use Symfony\Component\Yaml\Parser;

/**
 * Command to run fulfillment batch job
 *
 * @author Tony Rocha <tony.rocha@wakeupnow.com>
 */
class FulfillmentJobService
{
    private $fulfillmentConfigsFolder;

    private $container;

    public function __construct($container)
    {
        $this->container = $container;
        $this->fulfillmentConfigsFolder = '/var/www/orchid/sylius/src/Sylius/Bundle/FulfillmentBundle/Resources/config/fulfillmentMappings/'; //TODO: make this not hardcoded
    }

    public function execute(array $params)
    {
        if($this->checkParams($params) == false)
        {
            //TODO: validate params, if needed
            return false;
        }

        $orderRepo = $this->container->get('sylius.repository.order');
        $orderItemRepo = $this->container->get('sylius.repository.order_item');

        /** @var ShipmentState $readyState */
        $readyState = $this->container->get('sylius.repository.shipment_state')->findByName(ShipmentState::READY)[0];

        $orders = $orderRepo->findByShippingState($readyState->getId()); //TODO: Figure out what the state of the order should be in order to be eligible for fulfillment
        //Fulfillments have to be grouped by product, but since the starting point is orders, iterate through all orders
        //and store all orders and order items by product
        $fulfillments = [];
        /** @var Order $order */
        foreach($orders as $order)
        {
            $orderItems = $orderItemRepo->findByOrder($order);
            /** @var OrderItem $orderItem */
            foreach($orderItems as $orderItem)
            {
                /** @var Product $product */
                $product = $orderItem->getProduct();
                if(array_key_exists($product->getId(), $fulfillments) == false)
                {
                    $fulfillments[$product->getId()] = [];
                }
                /** @var ProductVariant $variant */
                $variant = $orderItem->getVariant();
                $interval = $product->getFulfillment()->getInterval();
                if($this->getFulfillmentEligibility($interval) == true)
                {
                    $fulfillments[$product->getId()][$orderItem->getId()] = $orderItem;
                }
            }
        }
        $this->createFulfillmentFiles($fulfillments);
        //TODO: Send files
        //TODO: update orders to fulfilled
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

    /**
     * Returns whether the given array has all appropriate parameters.
     * If the interval part is null or empty, it should return true.
     *
     * @param array $params
     *
     * @return boolean
     */
    private function checkParams(array $params)
    {
        $res = true;
        //TODO: Implement this if needed.
        return $res;
    }

    /**
     * Given an array containing products and order items, creates fulfillment files for all products
     *
     * @param array $fulfillments
     *
     * @return boolean
     */
    private function createFulfillmentFiles(array $fulfillments)
    {
        foreach($fulfillments as $productId => $orderItems)
        {
//            \Doctrine\Common\Util\Debug::dump($fulfillments); die; //remove me
            $productRepo = $this->container->get('sylius.repository.product');

            $product = $productRepo->findOneById($productId);

            $fulfillment = $product->getFulfillment();
            $fileType = $fulfillment->getFileType();
            $fileName = 'test.txt'; //TODO: change to $fulfillmentProvider->getParameters()['outboundFilename'] or something like that
            $mappingFileName = 'WakeUpNowMapping.yml';//TODO: change to $fulfillmentProvider->getParameters()['FulfillmentExportMappingFilename'] or something like that

            $mappings = $this->getMapping($mappingFileName);


            /** @var WriterInterface $writer */
            $writer = $this->getWriter([
                'fulfillmentFileType'   => $fileType->getName(),
                'fileName'              => $fileName,
            ]);
            $writer->prepare();

            $valuesArray = [];
            /** @var OrderItem $orderItem */
            foreach($orderItems as $orderItemId => $orderItem)
            {
                $entityArray['product'] =  $product;
                $entityArray['order_item'] = $orderItem;
                $entityArray['order'] = $orderItem->getOrder();

                foreach($mappings as $class => $values)
                {
                    foreach($values as $property => $header)
                    {
                        $function = 'get'.$property;

                        $valuesArray[$header] = $entityArray[$class]->$function();
                    }
                }
                //var_dump($valuesArray); //remove me
                $writer->writeItem($valuesArray);
            }
            $writer->finish();
        }
    }

    /**
     * Given an array containing products and order items, fulfills each product
     *
     * Possible params:
     * fulfillmentFileType (Required) : A file type
     * fileName (Required): File name
     * mode(Optional, default = w) : File mode
     * delimiter(Delimiter, default = ;) : CSV delimiter
     * enclosure(Optional, default = ") : File mode
     *
     * @param array $params
     *
     * @return boolean
     *
     * @throws MissingOptionsException
     */
    private function getWriter(array $params)
    {

        if($params['fulfillmentFileType'] == null)
        {
            throw new MissingOptionsException('fulfillmentFileType option is missing from param list.', $params);
        }
        switch($params['fulfillmentFileType'])
        {
            case 'delimited':
            case 'csv':
            {
                if($params['fileName'] == null) throw new MissingOptionsException('fileName option is missing from param list. fileName is required for CsvWriter type.', $params);
                $mode = $params['mode'] == null ? 'w' : $params['mode'];
                $delimiter = $params['delimiter'] == null ? ',' : $params['delimiter'];
                $enclosure = $params['enclosure'] == null ? '"' : $params['enclosure'];
                $file = new \SplFileObject('/var/www/orchid/sylius/app/cache/'.$params['fileName'], $mode); //TODO: use appropriate directory for outbound files (WebBundle/Media?)
                return new CsvWriter($file, $mode, $delimiter, $enclosure);
                break;
            }
            case 'xml'://TODO: Implement xml file type. Not needed for first release.
                break;

            default:
                break;
        }
        throw new MissingOptionsException('fulfillmentFileType invalid.', $params);
    }

    /**
     * Given a filename, returns the mapping configuration
     *
     *
     * @param string $mappingFileName
     *
     * @return array
     *
     * @throws MissingOptionsException
     */
    private function getMapping($mappingFileName)
    {
        $fileName = $this->fulfillmentConfigsFolder.$mappingFileName;

        if(file_exists($fileName) == false)
        {
            throw new MissingOptionsException('Invalid config file. ' . $mappingFileName, $mappingFileName);
        }

        $parser = new Parser();
        $mappings = $parser->parse(file_get_contents($fileName));
        return $mappings;
    }
}