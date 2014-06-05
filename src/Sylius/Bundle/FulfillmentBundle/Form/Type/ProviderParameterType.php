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

use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Fulfillment form type.
 *
 * @author Tony Rocha <tony.rocha@wakeupnow.com>
 */
class ProviderParameterType extends AbstractType
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

    /*public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }*/


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parameterType', 'entity', array(
                'class'     => 'Sylius\Component\Fulfillment\Model\ParameterType',
                'property'  => 'name',
                'label'     => 'sylius.form.fulfillment.parameter_type',
            ))
            ->add('value', 'text', array(
                'required' => true,
                'label'    => 'Value',
                'attr'     => array(
                'placeholder' => 'Value'
                )
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

//    public function getParent()
//    {
//        return 'entity';
//    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_provider_parameter';
    }
}