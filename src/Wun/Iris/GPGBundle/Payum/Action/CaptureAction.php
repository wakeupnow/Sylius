<?php

namespace Wun\Iris\GPGBundle\Payum\Action;

use Wun\Iris\GPGBundle\Payum\Api\Api;
use Payum\Core\Action\PaymentAwareAction;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\Request\CaptureRequest;
use Payum\Core\Request\GetHttpQueryRequest;
use Payum\Core\Request\PostRedirectUrlInteractiveRequest;
use Payum\Core\Request\SecuredCaptureRequest;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Bundle\PayumBundle\Payum\Request\ObtainCreditCardRequest;

class CaptureAction extends PaymentAwareAction implements ApiAwareInterface
{
    /**
     * @var Api
     */
    protected $api;

    /**
     * {@inheritDoc}
     */
    public function setApi($api)
    {
        if (false === $api instanceof Api) {
            throw new UnsupportedApiException('Not supported.');
        }

        $this->api = $api;
    }

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

            $details = array(
            'APIUsername' =>urlencode($apiusername),
            'APIPwd' =>urlencode($apipassword),
            'ClientID' =>urlencode($clientid),
            'Amount'=> number_format($order->getTotal() / 100, 2),
            'EmployeeID' =>urlencode("9999"),
            'SSNSSI' => urlencode("102354699"),
            'Description'=>urlencode("Test Payment"),
            'Rundate' =>urlencode("1/1/1901")
            );

        }

        $getHttpQuery = new GetHttpQueryRequest();
        $this->payment->execute($getHttpQuery);

        //we are back from GPG site so we have to just update model.
        if (isset($getHttpQuery['ResponsePayout']['Response'])) {
            $model->replace($getHttpQuery);
        } else {
            throw new PostRedirectUrlInteractiveRequest(
                $this->api->getGPGWsdl(),
                $this->api->instantSubmitPayoutRequest($details)
            );
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