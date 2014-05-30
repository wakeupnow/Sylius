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

class IntervalRepository extends EntityRepository
{
    /**
     * Get the product data for the details page.
     *
     * @param integer $id
     *
     * @return null|Interval
     */
    public function findForDetailsPage($id)
    {
       $queryBuilder = $this->getQueryBuilder();

        $this->_em->getFilters()->disable('softdeleteable');

        $queryBuilder
            ->andWhere($queryBuilder->expr()->eq('interval.id', ':id'))
            ->setParameter('id', $id)
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
        return 'interval';
    }
}