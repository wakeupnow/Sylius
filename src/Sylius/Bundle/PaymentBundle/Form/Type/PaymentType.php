<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\PaymentBundle\Form\Type;

use Sylius\Component\Payment\Model\PaymentState;
use Sylius\Component\Payment\Model\PaymentInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Payment form type.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PaymentType extends AbstractType
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
    public function __construct($dataClass, array $validationGroups)
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
            ->add('method', 'sylius_payment_method_choice', array(
                'label' => 'sylius.form.payment.method'
            ))
            ->add('amount', 'sylius_money', array(
                'label' => 'sylius.form.payment.amount'
            ))
            ->add('state', 'choice', array(
                'label'   => 'sylius.form.payment.state',
                'choices' => array(
                    PaymentState::PROCESSING => 'sylius.form.payment.state.processing',
                    PaymentState::PENDING    => 'sylius.form.payment.state.pending',
                    PaymentState::FAILED     => 'sylius.form.payment.state.failed',
                    PaymentState::VOID       => 'sylius.form.payment.state.void',
                    PaymentState::COMPLETED  => 'sylius.form.payment.state.completed',
                    PaymentState::CREATED        => 'sylius.form.payment.state.new',
                    PaymentState::CANCELLED  => 'sylius.form.payment.state.cancelled',
                    PaymentState::REFUNDED   => 'sylius.form.payment.state.refunded',
                    PaymentState::UNKNOWN    => 'sylius.form.payment.state.unknown'
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

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_payment';
    }
}
