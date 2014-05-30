<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Attribute\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Model for object attributes.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Attribute implements AttributeInterface
{
    /**
     * Attribute id.
     *
     * @var mixed
     *
     * @Serializer\Type("integer")
     */
    protected $id;

    /**
     * Internal name.
     *
     * @var string
     *
     * @Serializer\Type("string")
     */
    protected $name;

    /**
     * Type.
     *
     * @var string
     *
     * @Serializer\Type("string")
     */
    protected $type = AttributeTypes::TEXT;

    /**
     * Presentation.
     * Displayed to user.
     *
     * @var string
     *
     * @Serializer\Type("string")
     */
    protected $presentation;

    /**
     * Attribute configuration.
     *
     * @var array
     *
     * @Serializer\Type("array")
     */
    protected $configuration = array();

    /**
     * Creation time.
     *
     * @var \DateTime
     *
     * @Serializer\Type("DateTime")
     */
    protected $createdAt;

    /**
     * Last update time.
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
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * {@inheritdoc}
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;

        return $this;
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
