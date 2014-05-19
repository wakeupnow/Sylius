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

//use Sylius\Component\Order\Model\OrderInterface;

/**
 * Cart model interface.
 * All driver cart entities or documents should implement this interface.
 *
 * @author Tony Rocha <tony.rocha@wakeupnow.com>
 */
interface ParameterTypeInterface
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

}
