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
 * Attribute to subject relation.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class AttributeValue implements AttributeValueInterface
{
    /**
     * Id.
     *
     * @var integer
     *
     * @Serializer\Type("integer")
     */
    protected $id;

    /**
     * Subject.
     *
     * @var SubjectInterface
     *
     * @Serializer\Type("Sylius\Component\Core\Model\Product")
     */
    protected $subject;

    /**
     * Attribute.
     *
     * @var AttributeInterface
     *
     * @Serializer\Type("Sylius\Component\Attribute\Model\Attribute")
     */
    protected $attribute;

    /**
     * Attribute value.
     *
     * @var mixed
     *
     * @Serializer\Type("string")
     */
    protected $value;

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string) $this->value;
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
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject(SubjectInterface $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttribute(AttributeInterface $attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        if ($this->attribute && AttributeTypes::CHECKBOX === $this->attribute->getType()) {
            return (Boolean) $this->value;
        }

        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        $this->assertAttributeIsSet();

        return $this->attribute->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getPresentation()
    {
        $this->assertAttributeIsSet();

        return $this->attribute->getPresentation();
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        $this->assertAttributeIsSet();

        return $this->attribute->getType();
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        $this->assertAttributeIsSet();

        return $this->attribute->getConfiguration();
    }

    /**
     * @throws \BadMethodCallException When attribute is not set
     */
    protected function assertAttributeIsSet()
    {
        if (null === $this->attribute) {
            throw new \BadMethodCallException('The attribute is undefined, so you cannot access proxy methods.');
        }
    }
}
