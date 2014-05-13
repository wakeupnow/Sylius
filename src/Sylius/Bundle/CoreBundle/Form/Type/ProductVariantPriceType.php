<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ProductVariantPriceType
 * @package Sylius\Bundle\CoreBundle\Form\Type
 */
class ProductVariantPriceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'sylius_money')
            ->add('type', 'entity', [
                'class' => 'Sylius\Component\Core\Model\PriceType'
            ])
            ->add('accountTypes', 'entity', [
                'class' => 'Wun\Shared\DomainModelsBundle\Entity\AccountType',
                'multiple' => true
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'Sylius\Component\Core\Model\ProductVariantPrice'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_product_variant_price';
    }
}
