<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\OrderBundle\Doctrine\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Order\Repository\OrderRepositoryInterface;

/**
 * Order repository.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class OrderRepository extends EntityRepository implements OrderRepositoryInterface
{

    public function getItemByOrderAndProduct($order, $product)
    {
        $qb = $this->getQueryBuilder();
        $qb->select($this->getAlias())
            ->innerJoin('oi.order', 'o')
            ->innerJoin('oi.variant', 'v')
            ->innerJoin('v.object', 'p')
            ->andWhere('o = :order')
            ->andWhere('p = :product')
            ->setParameters(array('order' => $order, 'product' => $product))
        ;
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getFormQueryBuilder()
    {
        return $this->getCollectionQueryBuilder();
    }

     /**
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->select($this->getAlias())
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'orderItem';
    }
}
