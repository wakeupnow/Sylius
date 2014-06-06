<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Wun
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Interval repository.
 *
 * @author Abdullah Kiser <kiser.bd@gmail.com>
 */
namespace Sylius\Bundle\AutoPayBundle\Doctrine\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
//use Doctrine\ORM\EntityRepository,
//    Doctrine\ORM\Query\Expr,
//    Doctrine\ORM\QueryBuilder;

class AutoPayRepository extends EntityRepository
{    
    public function getDueByDate($nextDate)
    {
        $qb = $this->getQueryBuilder();
        $qb->select($this->getAlias())
           ->andWhere("DATE_FORMAT(autoPay.nextDate,'%Y-%m-%d') = :nextDate")
           ->setParameter('nextDate', $nextDate)
           ->orderBy('autoPay.order')
        ;

         $query = $qb->getQuery(); //print $query->getSQL(); exit;
         return $query->getResult();
    }

    public function getOrdersOfDate($nextDate)
    {
        $qb = $this->getQueryBuilder();
        $qb->select('autoPay.order')
           ->andWhere("DATE_FORMAT(autoPay.nextDate,'%Y-%m-%d') = :nextDate")
           ->setParameter('nextDate', $nextDate)
           ->groupBy('autoPay.order')
        ;

        $query = $qb->getQuery(); //print $query->getSQL(); exit;
        return $query->getArrayResult();
    }

    public function getByOrder($order)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->andWhere("autoPay.order, = :order")
            ->setParameter('order', $order)
            ->orderBy('autoPay.nextDate')
        ;

        $result = $queryBuilder
            ->getQuery()
            ->getResult()
        ;

        return $result;
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
        return 'autoPay';
    }
}