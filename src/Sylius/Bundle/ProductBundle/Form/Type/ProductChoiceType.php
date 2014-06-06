<?php

namespace Sylius\Bundle\ProductBundle\Form\Type;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\Product\Model\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ObjectChoiceList;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductChoiceType extends AbstractType
{
    protected $productRepository;

    public function __construct(RepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $products = $this->productRepository->findAll();

        $options['model_transformer']['class'] = 'Sylius\Bundle\ResourceBundle\Form\DataTransformer\ObjectSelectionToIdentifierCollectionTransformer';
        $options['model_transformer']['save_objects'] = false;
        
        $builder->addModelTransformer(new $options['model_transformer']['class']($products, $options['model_transformer']['save_objects']));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class'        => null,
                'multiple'          => true,
                'render_label'      => false,
                'model_transformer' => 'Sylius\Bundle\ResourceBundle\Form\DataTransformer\ObjectSelectionToIdentifierCollectionTransformer',
            ))
        ;

        $resolver
            ->setNormalizers(array(
                'model_transformer' => function (Options $options, $value) {
                    if (!is_array($value)) {
                        $value = array('class' => $value);
                    } else {
                        if (!isset($value['class'])) {
                            $value['class'] = 'Sylius\Bundle\ResourceBundle\Form\DataTransformer\ObjectSelectionToIdentifierCollectionTransformer';
                        }
                    }

                    if (!isset($value['save_objects'])) {
                        $value['save_objects'] = true;
                    }
                },
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

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_product_choice';
    }
}
