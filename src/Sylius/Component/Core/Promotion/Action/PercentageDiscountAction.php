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
 * Percentage discount action.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PercentageDiscountAction implements PromotionActionInterface
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
        // Product promo -----------------------------------------------------------------------------------------------

        // this is a proof of what we can apply needed adjustments,
        // i used lambdas just to keep all this experiment code together

        $adjustmentRepository = $this->repository;

        // this determines whether a promotion is of this new type
        $isProductPromotion = function (PromotionInterface $promotion) {
            foreach ($promotion->getRules() as $rule) {
                if ($rule->getType() == 'product') {
                    return true;
                }
            }

            return false;
        };

        // this compares Promotion with OrderItem, checks if OrderItem is eligible for this promotion and
        // if it's eligible it returns an Adjustment representing discount
        $getProductPromotionAdjustment = function(\Sylius\Component\Core\Model\OrderItemInterface $orderItem)
                                          use ($adjustmentRepository, $configuration, $promotion)
        {
            foreach ($promotion->getRules() as $rule) {
                if ($rule->getType() === 'product') {
                    $config = $rule->getConfiguration();

                    if ($config['products']->contains($orderItem->getProduct()->getId())
                        && $orderItem->getQuantity() >= $config['qty'])
                    {
                        $adjustment = $adjustmentRepository->createNew();
                        $adjustment->setAmount(- $orderItem->getTotal() * $configuration['percentage']);
                        $adjustment->setLabel(OrderInterface::PROMOTION_ADJUSTMENT);
                        $adjustment->setDescription($promotion->getDescription());

                        return $adjustment;
                    }
                }
            }

            return null;
        };

        // DEBUG ---------- (stores all the Adjustments applied for promotions of the new product type)
        $adjustments = [];
        // ----------------

        // the body of our hack:
        // if promotion is of a product type,
        // then check all order items and apply Adjustments where necessarily
        if ($isProductPromotion($promotion)) {

            // this additional IF to process a special case clearly indicates a lack of polymorphism in this code,
            // the proper solution would be to turn an OrderItem to PromotionSubject and process it the same way as
            // Order is processed, but this may be faster to get, especially if the rest of the code expects
            // OrderInterface everywhere PromotionInterface is used

            foreach ($subject->getItems() as $orderItem) {
                if ($adjustment = $getProductPromotionAdjustment($orderItem)) {
                    $subject->addAdjustment($adjustment);
                    $adjustments[] = $adjustment;
                }
            }
        }

        // DEBUG ------------------------------------------- (dump Adjustments created by product promotions)
        echo "Product adjustments applied:\n\n\n";
        \Doctrine\Common\Util\Debug::dump($adjustments);die;
        // -------------------------------------------------

        // Product promo -----------------------------------------------------------------------------------------------

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
