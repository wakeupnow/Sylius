<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Wun
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\AutoPayBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Tax rate form type.
 *
 * @author Abdullah Kiser <kiser.bd@gmail.com>
 */
class IntervalType extends AbstractType
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
            ->add('minute', 'text', array(
                'label' => 'sylius.form.interval.minute'
            ))
            ->add('hour', 'text', array(
                'label' => 'sylius.form.interval.hour'
            ))
            ->add('dayMonth', 'text', array(
                'label' => 'sylius.form.interval.day_month',
            ))
            ->add('month', 'text', array(
                'label' => 'sylius.form.interval.month'
            ))
            ->add('dayWeek', 'text', array(
                'label' => 'sylius.form.interval.day_week'
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
        return 'sylius_interval';
    }
}