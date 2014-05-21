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
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Cart model interface.
 * All Fulfillment Provider entities or documents should implement this interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 *
 */

interface FulfillmentProviderInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param Protocol $protocol
     */
    public function setProtocol($protocol);

    /**
     * @return Protocol
     */
    public function getProtocol();

    /**
     * @param FileType $fileType
     */
    public function setFileType($fileType);

    /**
     * @return FileType
     */
    public function getFileType();

    /**
     * @param Interval $interval
     */
    public function setInterval($interval);

    /**
     * @return Interval
     */
    public function getInterval();

    /**
     * @param ArrayCollection $parameters
     */
    public function setParameters($parameters);

    /**
     * @return ArrayCollection
     */
    public function getParameters();
}
