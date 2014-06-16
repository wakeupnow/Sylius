<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Core\Promotion\Action;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Promotion\Action\PromotionActionInterface;
use Sylius\Component\Promotion\Model\PromotionInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * Fixed discount action.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ChangeCVAction implements PromotionActionInterface
{
    /**
     * Adjustment repository.
     *
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(PromotionSubjectInterface $subject, array $configuration, PromotionInterface $promotion)
    {
        foreach ($subject->getItems() as $item) {
            foreach ($promotion->getRules() as $rule) {
                $config  = $rule->getConfiguration();
                $product = $item->getProduct();

                if ($config['products']->contains($product->getId()) && $item->getQuantity() >= $config['qty']) {
                    $cv = null;
                    foreach ($product->getAttributes() as $attributeValue) {
                        $attribute = $attributeValue->getAttribute();

                        if ($attribute->getName() === 'CV') {
                            $cv = $attributeValue->getValue();
                            break;
                        }
                    }

                    if (null === $cv) {
                        continue;
                    }

                    $adjustment = $this->repository->createNew();
                    
                    $adjustment->setCV($item->getQuantity() * ($configuration['cv'] - $cv));
                    $adjustment->setLabel(OrderInterface::CV_ADJUSTMENT);
                    $adjustment->setDescription($promotion->getDescription());

                    $subject->addAdjustment($adjustment);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function revert(PromotionSubjectInterface $subject, array $configuration, PromotionInterface $promotion)
    {
        $subject->removeCVAdjustments();
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigurationFormType()
    {
        return 'sylius_promotion_action_change_cv_configuration';
    }
}
