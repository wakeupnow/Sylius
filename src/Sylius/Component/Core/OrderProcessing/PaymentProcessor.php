<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Core\OrderProcessing;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\Payment\Model\PaymentStateInterface;

/**
 * Payment processor.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PaymentProcessor implements PaymentProcessorInterface
{
    /**
     * Payment repository.
     *
     * @var RepositoryInterface
     */
    protected $paymentRepository;

    /**
     * @var RepositoryInterface
     */
    protected $stateRepository;

    /**
     * @param RepositoryInterface $paymentRepository
     * @param RepositoryInterface $stateRepository
     */
    public function __construct(RepositoryInterface $paymentRepository, RepositoryInterface $stateRepository)
    {
        $this->paymentRepository = $paymentRepository;
        $this->stateRepository = $stateRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function createPayment(OrderInterface $order)
    {
        $payment = $this->paymentRepository->createNew();

        $payment->setCurrency($order->getCurrency());
        $payment->setAmount($order->getTotal());

        $state = $this->stateRepository->findOneBy(['name' => PaymentStateInterface::CREATED]);
        $payment->setState($state);

        $order->setPayment($payment);

        return $payment;
    }
}
