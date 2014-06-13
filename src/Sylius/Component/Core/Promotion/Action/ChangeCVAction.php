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

use Sylius\Component\Core\Model\OrderItemInterface;
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
                $config = $rule->getConfiguration();

                if ($config['products']->contains($item->getProduct()->getId()) && $item->getQuantity() >= $config['qty']) {
                    $adjustment = $this->repository->createNew();

                    //$adjustment->setAttribute();
                    $adjustment->setLabel(OrderItemInterface::PROMOTION_ADJUSTMENT);
                    $adjustment->setDescription($promotion->getDescription());

                    /*echo '<pre>';
                    \Doctrine\Common\Util\Debug::dump(get_class_methods($adjustment));
                    echo '</pre>';
                    die;*/

                    $item->addAdjustment($adjustment);

                    /*echo '<pre>';
                    \Doctrine\Common\Util\Debug::dump(get_class_methods($item));
                    echo '</pre>';
                    die;*/
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function revert(PromotionSubjectInterface $subject, array $configuration, PromotionInterface $promotion)
    {
        foreach ($subject->getItems() as $item) {
            $item->removePromotionAdjustments();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigurationFormType()
    {
        return 'sylius_promotion_action_change_cv_configuration';
    }
}
