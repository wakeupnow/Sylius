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
 * Model for Provider Parameters.
 * All driver entities and documents should extend this class or implement
 * proper interface.
 *
 * @author Tony Rocha <tony.rocha@wakeupnow.com>
 */
//class ProviderParameter extends Order implements ProviderParameterInterface.php
class ProviderParameter implements ProviderParameterInterface
{
    /**
     * Id.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Parameter Type.
     *
     * @var ParameterType
     */
    protected $parameterType;

    /**
     * Parameter Value.
     *
     * @var string
     */
    protected $value;

    /**
     * Fulfillment Provider.
     *
     * @var string
     */
    protected $fulfillmentProvider;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param ParameterType $parameterType
     */
    public function setParameterType($parameterType)
    {
        $this->parameterType = $parameterType;
    }

    /**
     * @return ParameterType
     */
    public function getParameterType()
    {
        return $this->parameterType;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $fulfillmentProvider
     */
    public function setFulfillmentProvider($fulfillmentProvider)
    {
        $this->fulfillmentProvider = $fulfillmentProvider;
    }

    /**
     * @return FulfillmentProvider
     */
    public function getFulfillmentProvider()
    {
        return $this->fulfillmentProvider;
    }
}
