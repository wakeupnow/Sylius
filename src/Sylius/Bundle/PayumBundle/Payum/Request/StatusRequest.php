<?php

/*
* This file is part of the Sylius package.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sylius\Bundle\PayumBundle\Payum\Request;

use Payum\Core\Request\BaseStatusRequest;
use Sylius\Component\Payment\Model\PaymentState;
use Sylius\Component\Payment\Model\PaymentInterface;

class StatusRequest extends BaseStatusRequest
{
    /**
     * {@inheritdoc}
     */
    public function markNew()
    {
        $this->status = PaymentState::CREATED;
    }

    /**
     * {@inheritdoc}
     */
    public function isNew()
    {
        return $this->status === PaymentState::CREATED;
    }

    /**
     * {@inheritdoc}
     */
    public function markSuccess()
    {
        $this->status = PaymentState::COMPLETED;
    }

    /**
     * {@inheritdoc}
     */
    public function isSuccess()
    {
        return $this->status === PaymentState::COMPLETED;
    }

    /**
     * {@inheritdoc}
     */
    public function markSuspended()
    {
        $this->status = PaymentState::PROCESSING;
    }

    /**
     * {@inheritdoc}
     */
    public function isSuspended()
    {
        return $this->status === PaymentState::PROCESSING;
    }

    /**
     * {@inheritdoc}
     */
    public function markExpired()
    {
        $this->status = PaymentState::FAILED;
    }

    /**
     * {@inheritdoc}
     */
    public function isExpired()
    {
        return $this->status === PaymentState::FAILED;
    }

    /**
     * {@inheritdoc}
     */
    public function markCanceled()
    {
        $this->status = PaymentState::CANCELLED;
    }

    /**
     * {@inheritdoc}
     */
    public function isCanceled()
    {
        return $this->status === PaymentState::CANCELLED;
    }

    /**
     * {@inheritdoc}
     */
    public function markPending()
    {
        $this->status = PaymentState::PROCESSING;
    }

    /**
     * {@inheritdoc}
     */
    public function isPending()
    {
        return $this->status === PaymentState::PROCESSING;
    }

    /**
     * {@inheritdoc}
     */
    public function markFailed()
    {
        $this->status = PaymentState::FAILED;
    }

    /**
     * {@inheritdoc}
     */
    public function isFailed()
    {
        return $this->status === PaymentState::FAILED;
    }

    /**
     * {@inheritdoc}
     */
    public function markUnknown()
    {
        $this->status = PaymentState::UNKNOWN;
    }

    /**
     * {@inheritdoc}
     */
    public function isUnknown()
    {
        return $this->status === PaymentState::UNKNOWN;
    }
}
