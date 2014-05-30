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

class AutoPayRepository extends EntityRepository
{    
    public function getDueByDate($nextDate)
    {
         $queryBuilder
            ->andWhere("DATE_FORMAT(autoPay.nextDate,'%Y-%m-%d') = :nextDate")
            ->setParameter('nextDate', $nextDate)
        ;

        $result = $queryBuilder
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $result;
    }

    public function getByOrder($order)
    {
        $queryBuilder
            ->andWhere("autoPay.order, = :order")
            ->setParameter('order', $order)
        ;

        $result = $queryBuilder
            ->getQuery()
            ->getOneOrNullResult()
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