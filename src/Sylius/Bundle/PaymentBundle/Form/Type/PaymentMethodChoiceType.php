<?php

namespace Sylius\Bundle\PaymentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class PaymentMethodChoiceType
 * @package Sylius\Bundle\PaymentBundle\Form\Type
 */
abstract class PaymentMethodChoiceType extends AbstractType
{
    /**
     * Payment method class name.
     *
     * @var string
     */
    protected $className;

    /**
     * Constructor.
     *
     * @param string $className
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'class'    => $this->className,
                'disabled' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_payment_method_choice';
    }
}