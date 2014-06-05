<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Wun
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\FulfillmentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Fulfillment form type.
 *
 * @author Tony Rocha <tony.rocha@wakeupnow.com>
 */
class FulfillmentType extends AbstractType
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

    protected $repository;

    /**
     * Constructor.
     *
     * @param string $dataClass
     * @param array  $validationGroups
     */
    public function __construct($dataClass, array $validationGroups = null)
    {
        $this->dataClass = $dataClass;
        $this->validationGroups = $validationGroups;
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('fileType', 'entity', array(
                'class'     => 'Sylius\Component\Fulfillment\Model\FileType',
                'property'  => 'name',
                'label'     => 'sylius.form.fulfillment.file_type',
            ))
            ->add('fulfillmentProvider', 'entity', array(
                'class'     => 'Sylius\Component\Fulfillment\Model\FulfillmentProvider',
                'property'  => 'name',
                'label'     => 'sylius.form.fulfillment.provider',
            ))
            ->add('protocol', 'entity', array(
                'class'     => 'Sylius\Component\Fulfillment\Model\Protocol',
                'property'  => 'name',
                'label'     => 'sylius.form.fulfillment.protocol',
            ))
            ->add('interval', 'sylius_interval', array(
                'data_class' => 'Sylius\Component\AutoPay\Model\Interval', //TO_DO: make this value configurable
                'label'      => 'Interval',
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
                'data_class'        => $this->dataClass,
                'validation_groups' => $this->validationGroups,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_fulfillment';
    }
}