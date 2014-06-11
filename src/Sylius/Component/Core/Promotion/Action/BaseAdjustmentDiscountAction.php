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
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Promotion\Action\PromotionActionInterface;
use Sylius\Component\Promotion\Model\PromotionInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * Class BaseAdjustmentDiscountAction
 *
 * @package Sylius\Component\Core\Promotion\Action
 */
abstract class BaseAdjustmentDiscountAction implements PromotionActionInterface
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
     * @param PromotionInterface $promotion
     * @return bool
     */
    protected function isProductPromotion(PromotionInterface $promotion)
    {
        foreach ($promotion->getRules() as $rule) {
            if ($rule->getType() == 'product') {
                return true;
            }
        }

        return false;
    }

    /**
     * @param PromotionSubjectInterface $subject
     * @param array $configuration
     * @param PromotionInterface $promotion
     */
    protected function executeProductPromotion(PromotionSubjectInterface $subject,
                                            array $configuration,
                                            PromotionInterface $promotion)
    {
        foreach ($subject->getItems() as $orderItem) {
            foreach ($promotion->getRules() as $rule) {
                if ($rule->getType() === 'product') {
                    $config = $rule->getConfiguration();

                    if ($config['products']->contains($orderItem->getProduct()->getId())
                        && $orderItem->getQuantity() >= $config['qty'])
                    {
                        $adjustment = $this->repository->createNew();

                        $adjustment->setAmount($this->getProductPromotionAdjustmentAmount($orderItem, $configuration));
                        $adjustment->setLabel(OrderInterface::PROMOTION_ADJUSTMENT);
                        $adjustment->setDescription($promotion->getDescription());

                        $subject->addAdjustment($adjustment);
                    }
                }
            }
        }
    }

    /**
     * @param OrderItemInterface $orderItem
     * @param array $configuration
     * @return mixed
     */
    protected abstract function getProductPromotionAdjustmentAmount(OrderItemInterface $orderItem,
                                                                    array $configuration);

    /**
     * @param PromotionSubjectInterface $subject
     * @param array $configuration
     * @param PromotionInterface $promotion
     * @return mixed
     */
    protected abstract function executeNonProductPromotion(PromotionSubjectInterface $subject,
                                                           array $configuration,
                                                           PromotionInterface $promotion);

    /**
     * {@inheritdoc}
     */
    public function execute(PromotionSubjectInterface $subject, array $configuration, PromotionInterface $promotion)
    {
        if ($this->isProductPromotion($promotion)) {
            $this->executeProductPromotion($subject, $configuration, $promotion);
        }
        else {
            $this->executeNonProductPromotion($subject, $configuration, $promotion);
        }
    }
}
