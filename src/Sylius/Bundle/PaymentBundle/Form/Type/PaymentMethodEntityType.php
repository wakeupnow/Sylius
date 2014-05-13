<?php

namespace Sylius\Bundle\PaymentBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class PaymentMethodEntityType
 * @package Sylius\Bundle\PaymentBundle\Form\Type
 */
class PaymentMethodEntityType extends PaymentMethodChoiceType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $queryBuilder = function (Options $options) {
            return function (EntityRepository $repository) {
                return $repository->createQueryBuilder('method');
            };
        };

        $resolver
            ->setDefaults(array(
                'query_builder' => $queryBuilder
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'entity';
    }
}
