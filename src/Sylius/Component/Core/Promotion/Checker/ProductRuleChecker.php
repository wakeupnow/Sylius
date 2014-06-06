<?php

namespace Sylius\Component\Core\Promotion\Checker;

use Sylius\Bundle\ResourceBundle\Exception\UnexpectedTypeException;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Promotion\Checker\RuleCheckerInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;

class ProductRuleChecker implements RuleCheckerInterface
{
    /**
     * {@inheritdoc}
     */
    public function isEligible(PromotionSubjectInterface $subject, array $configuration)
    {
        if (!$subject instanceof OrderInterface) {
            throw new UnexpectedTypeException($subject, 'Sylius\Component\Core\Model\OrderInterface');
        }

        foreach ($subject->getItems() as $item) {
            $product = $item->getProduct();
            $qty = $item->getQuantity();

            if ($configuration['products']->contains($product->getId()) && $qty >= $configuration['qty']) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigurationFormType()
    {
        return 'sylius_promotion_rule_product_configuration';
    }
}
