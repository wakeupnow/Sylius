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
use Sylius\Component\Promotion\Model\PromotionInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;

/**
 * Percentage discount action.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PercentageDiscountAction extends BaseAdjustmentDiscountAction
{
    /**
     * @param OrderItemInterface $orderItem
     * @param array $configuration
     * @return mixed
     */
    protected function getProductPromotionAdjustmentAmount(OrderItemInterface $orderItem, array $configuration)
    {
        return -$orderItem->getTotal() * $configuration['percentage'];
    }

    /**
     * @param PromotionSubjectInterface $subject
     * @param array $configuration
     * @param PromotionInterface $promotion
     * @return mixed
     */
    protected function executeNonProductPromotion(PromotionSubjectInterface $subject,
                                                  array $configuration,
                                                  PromotionInterface $promotion)
    {
        $adjustment = $this->repository->createNew();

        $adjustment->setAmount(- $subject->getPromotionSubjectItemTotal() * ($configuration['percentage']));
        $adjustment->setLabel(OrderInterface::PROMOTION_ADJUSTMENT);
        $adjustment->setDescription($promotion->getDescription());

        $subject->addAdjustment($adjustment);
    }

    /**
     * {@inheritdoc}
     */
    public function revert(PromotionSubjectInterface $subject, array $configuration, PromotionInterface $promotion)
    {
        $subject->removePromotionAdjustments();
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigurationFormType()
    {
        return 'sylius_promotion_action_percentage_discount_configuration';
    }
}
