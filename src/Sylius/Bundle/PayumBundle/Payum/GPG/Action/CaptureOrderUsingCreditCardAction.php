<?php

namespace Sylius\Bundle\PayumBundle\Payum\GPG\Action;

use Payum\Core\Action\PaymentAwareAction;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\Request\CaptureRequest;
use Payum\Core\Request\GetHttpQueryRequest;
use Payum\Core\Request\PostRedirectUrlInteractiveRequest;
use Payum\Core\Request\SecuredCaptureRequest;
use Payum\Core\Security\SensitiveValue;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Bundle\PayumBundle\Payum\Request\ObtainCreditCardRequest;

class CaptureOrderUsingCreditCardAction extends PaymentAwareAction
{
     /**
     * {@inheritDoc}
     *
     * @throws PostRedirectUrlInteractiveRequest if authorization required.
     */
    public function execute($request)
    {
        /** @var $request CaptureRequest */
        if (false == $this->supports($request)) {
            throw RequestNotSupportedException::createActionNotSupported($this, $request);
        }

        /* @var $model \Sylius\Component\Core\Model\OrderInterface */
        $order = $request->getModel();
        $payment = $order->getPayment();
        $details = $payment->getDetails();

        if (empty($details)) {
            $this->payment->execute($obtainCreditCardRequest = new ObtainCreditCardRequest($order));
            
            //TODO: This capture will update after done with the payment functionality.
            $details = array(
//            'APIUsername' =>urlencode($apiusername),
//            'APIPwd' =>urlencode($apipassword),
//            'ClientID' =>urlencode($clientid),
            'Amount'=> number_format($order->getTotal() / 100, 2),
            'CCNumber' => new SensitiveValue($obtainCreditCardRequest->getCreditCard()->getNumber()),
            'CVV' => new SensitiveValue($obtainCreditCardRequest->getCreditCard()->getSecurityCode()),
            'EmployeeID' =>urlencode("9999"),
            'SSNSSI' => '',
            'Description'=>urlencode("Test Payment"),
            'Rundate' =>new SensitiveValue(sprintf(
                    '%02d-%02d', $obtainCreditCardRequest->getCreditCard()->getExpiryMonth(), substr($obtainCreditCardRequest->getCreditCard()->getExpiryYear(), -2)
                ))
            );

            $payment->setDetails($details);

        }

        try {
            $request->setModel($payment);
            $this->payment->execute($request);

            $request->setModel($order);
        } catch (\Exception $e) {
            $request->setModel($order);

            throw $e;
        }
    }

    /**
     * @param mixed $request
     *
     * @return boolean
     */
    function supports($request)
    {
        return $request instanceof SecuredCaptureRequest &&
            $request->getModel() instanceof OrderInterface;
    }
}