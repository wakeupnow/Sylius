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

use Sylius\Component\AutoPay\Model\Interval;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model for Fulfillment Providers.
 * All driver entities and documents should extend this class or implement
 * proper interface.
 *
 * @author Tony Rocha <tony.rocha@wakeupnow.com>
 */
class Fulfillment implements FulfillmentInterface
{
    /**
     * Id.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Fulfillment Provider.
     *
     * @var FulfillmentProvider
     */
    protected $fulfillmentProvider;

    /**
     * Protocol.
     *
     * @var Protocol
     */
    protected $protocol;

    /**
     * File Type.
     *
     * @var FileType
     */
    protected $fileType;

    /**
     * Interval.
     *
     * @var Interval
     */
    protected $interval;

    /**
     * Provider Parameters.
     *
     * @var ArrayCollection
     */
    protected $parameters;

    /**
     * Provider Parameters.
     *
     * @var ArrayCollection
     */
    protected $products;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param FileType $fulfillmentProvider
     */
    public function setFulfillmentProvider($fulfillmentProvider)
    {
        $this->fulfillmentProvider = $fulfillmentProvider;
    }

    /**
     * @return mixed
     */
    public function getFulfillmentProvider()
    {
        return $this->fulfillmentProvider;
    }

    /**
     * @param FileType $fileType
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
    }

    /**
     * @return FileType
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * @param Interval $interval
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;
    }

    /**
     * @return Interval
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @param Protocol $protocol
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
    }

    /**
     * @return Protocol
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param ArrayCollection $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return ArrayCollection
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

}
