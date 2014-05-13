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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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
            ->add('gateway', 'sylius_payment_gateway_choice', array(
                'label' => 'sylius.form.payment.gateway',
                'required' => false
            ))
            ->add('amount', 'sylius_money', array(
                'label' => 'sylius.form.payment.amount'
            ))
            ->add('state', 'entity', array(
                'label' => 'sylius.form.payment.state',
                'class' => 'Sylius\Component\Payment\Model\PaymentState'
            ))
            ->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $event) {
                /** @var PaymentInterface $payment */
                $payment = $event->getData();
                $form = $event->getForm();

                if ($form->get('gateway')->getViewData() == '') {
                    $payment->removeGateway(null);
                }
            })
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
