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

use Doctrine\Common\Collections\Collection;
use Sylius\Component\AutoPay\Model\Interval;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model for Fulfillment Providers.
 * All driver entities and documents should extend this class or implement
 * proper interface.
 *
 * @author Tony Rocha <tony.rocha@wakeupnow.com>
 */
class FulfillmentProvider implements FulfillmentProviderInterface
{
    /**
     * Id.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Fulfillment Provider Name.
     *
     * @var string
     */
    protected $name;

    /**
     * Fulfillment Provider Parameters.
     *
     * @var ArrayCollection
     */
    protected $parameters;

    public function __construct()
    {
        $this->parameters = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Collection|ProviderParameterInterface[] $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return Collection|ProviderParameterInterface[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }

}
