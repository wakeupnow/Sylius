<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ShippingBundle\Form\Type;

use Sylius\Component\Shipping\Model\ShipmentState;
use Sylius\Component\Shipping\Model\ShipmentInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Shipping form type.
 */
class ShipmentType extends AbstractType
{
    /**
     * Data class.
     *
     * @var string
     */
    protected $dataClass;

    /**
     * Validation groups.
     *
     * @var array
     */
    protected $validationGroups;

    /**
     * Constructor.
     *
     * @param string $dataClass
     */
    public function __construct($dataClass)
    {
        $this->dataClass = $dataClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('state', 'choice', array(
                'label'   => 'sylius.form.shipment.state',
                'choices' => array(
                    ShipmentState::CHECKOUT   => 'sylius.form.shipment.states.checkout',
                    ShipmentState::PENDING    => 'sylius.form.shipment.states.pending',
                    ShipmentState::READY      => 'sylius.form.shipment.states.ready',
                    ShipmentState::SHIPPED    => 'sylius.form.shipment.states.shipped',
                    ShipmentState::RETURNED   => 'sylius.form.shipment.states.returned',
                    ShipmentState::CANCELLED  => 'sylius.form.shipment.states.cancelled',
                ),
            ))
            ->add('tracking', 'text', array(
                'label'    => 'sylius.form.shipment.tracking_code',
                'required' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => $this->dataClass,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_shipment';
    }
}
