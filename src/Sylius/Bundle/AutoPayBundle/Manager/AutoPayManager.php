<?php
/*
 * This file is part of the Sylius package.
*
* (c) Wun
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sylius\Bundle\AutoPayBundle\Manager;

use Sylius\Bundle\AutoPayBundle\Doctrine\ORM\AutoPayRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Command to release expired pending orders
 *
 * @author Abdullah Kiser <kiser.bd@gmail.com>
 */
class AutoPayManager
{
    /** @var ContainerInterface */
    protected $container;

    protected $repository;

    /**
     * AutoPay manager.
     *
     * @var ObjectManager
     */
    protected $manager;

    /**
     *
     * @param ContainerInterface $container
     * @param ObjectManager $manager
     * @param AutoPayRepository $repository 
     */
    public function __construct(ContainerInterface $container,ObjectManager $manager, AutoPayRepository $repository){
        $this->container = $container;
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     *
     * @param OrderInterface $order
     */
    public function initAutoPayForProduct(OrderInterface $order)
    {
        $orderItems = $order->getItems();
        $autopys = $this->repository->findBy(array('order' => $order));        
        foreach($orderItems as $orderItem)
        {
            $product = $orderItem->getProduct();
            if($product->isAutoPay()){
                $interval = $product->getMasterVariant()->getInterval();
                
                $autoPay = $this->repository->createNew();
                $autoPay->setProduct($product);
                $autoPay->setOrder($order);
                $autoPay->setInterval($interval);
                $autoPay->setNextDate($this->_calculateNextDate($interval));
                $this->manager->persist($autoPay);
            }
        }

        $this->manager->flush();
    }

    /**
     *
     */
    public function placeAutoPayOrder()
    {
        $autoPays = $this->repository->getDueByDate(\date('Y-m-d'));

        foreach($autoPays as $autoPay){
            $order = $autoPay->getOrder();
            $product = $autoPay->getProduct();
            $newOrder = Clone $order;

            $this->manager->persist($newOrder);            
        }

        $this->manager->flush();
    }

    /**
     *
     * @param <type> $interval
     * @return date
     */
    private function _calculateNextDate($interval)
    {        
        $days = $interval->getNoOfDay();
        $nextDate  = mktime(0, 0, 0, date("m")  , date("d") + $days, date("Y"));
        $nextDate = \date("Y-m-d", $nextDate);
        return $nextDate;
    }
}
