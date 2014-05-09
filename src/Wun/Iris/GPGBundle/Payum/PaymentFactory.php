<?php
namespace Wun\Iris\GPGBundle\Payum;

use Payum\Core\Action\ExecuteSameRequestWithModelDetailsAction;
use Payum\Core\Payment;
use Payum\Core\Extension\EndlessCycleDetectorExtension;
//use Wun\Iris\GPGBundle\Payum\Action\CaptureOnsiteAction;
use Wun\Iris\GPGBundle\Payum\Action\CaptureAction;
use Wun\Iris\GPGBundle\Payum\Action\Action\StatusAction;

abstract class PaymentFactory
{
    /**
     * @param Api $api
     *
     * @return Payment
     */
    public static function create(Api $api)
    {
        $payment = new Payment;

        $payment->addApi($api);

        $payment->addExtension(new EndlessCycleDetectorExtension);

//        $payment->addAction(new CaptureOnsiteAction);
        $payment->addAction(new CaptureAction);
        $payment->addAction(new StatusAction);
        $payment->addAction(new ExecuteSameRequestWithModelDetailsAction);

        return $payment;
    }

    /**
     */
    private function __construct()
    {
    }
}