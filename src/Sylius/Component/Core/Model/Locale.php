<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Core\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Locale model.
 *
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class Locale implements LocaleInterface
{
    /**
     * Id
     *
     * @var integer
     * @Serializer\Type("integer")
     */
    protected $id;

    /**
     * Code.
     *
     * @var string
     * @Serializer\Type("string")
     */
    protected $code;

    /**
     * Activation status.
     *
     * @var Boolean
     * @Serializer\Type("boolean")
     */
    protected $enabled = true;

    /**
     * Creation date
     *
     * @var \DateTime
     *
     * @Serializer\Type("DateTime")
     */
    protected $createdAt;

    /**
     * Update date
     *
     * @var \DateTime
     *
     * @Serializer\Type("DateTime")
     */
    protected $updatedAt;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnabled($enabled)
    {
        $this->enabled = (Boolean) $enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
