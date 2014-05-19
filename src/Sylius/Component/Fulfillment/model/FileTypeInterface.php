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
interface FileTypeInterface
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
     * @return name
     */
    public function getName();
}
