<?php

/*
* This file is part of the Sylius package.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sylius\Bundle\CoreBundle\Checkout\Step;

use Payum\Bundle\PayumBundle\Security\TokenFactory;
use Payum\Core\Registry\RegistryInterface;
use Payum\Core\Security\HttpRequestVerifierInterface;
use Sylius\Bundle\CoreBundle\Event\PurchaseCompleteEvent;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Bundle\PayumBundle\Payum\Request\StatusRequest;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\SyliusCheckoutEvents;
use Sylius\Component\Payment\SyliusPaymentEvents;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sylius\Component\Payment\Model\PaymentState;

class PurchaseStep extends CheckoutStep
{
    /**
     * {@inheritdoc}
     */
    public function displayAction(ProcessContextInterface $context)
    {
        $order = $this->getCurrentCart();
        //Dispatch shipping step events
        $this->dispatchCheckoutEvent(SyliusCheckoutEvents::SHIPPING_INITIALIZE, $order);

        $captureToken = $this->getTokenFactory()->createCaptureToken(
            $order->getPayment()->getMethod()->getName(),
            $order,
            'sylius_checkout_forward',
            array('stepName' => $this->getName())
        );

        return new RedirectResponse($captureToken->getTargetUrl());
    }

    /**
     * {@inheritdoc}
     */
    public function forwardAction(ProcessContextInterface $context)
    {
        $token = $this->getHttpRequestVerifier()->verify($this->getRequest());
        $this->getHttpRequestVerifier()->invalidate($token);

        $status = new StatusRequest($token);
        $this->getPayum()->getPayment($token->getPaymentName())->execute($status);

        /** @var OrderInterface $order */
        $order = $status->getModel();
        
        //Dispatch shipping step events
        $this->dispatchCheckoutEvent(SyliusCheckoutEvents::SHIPPING_INITIALIZE, $order);

        if (!$order instanceof OrderInterface) {
            throw new \RuntimeException(sprintf('Expected order to be set as model but it is %s', get_class($order)));
        }

        $payment = $order->getPayment();
        $previousState = $order->getPayment()->getState();

        $newState = $this->getManager()
                         ->getRepository('Sylius\Component\Payment\Model\PaymentState')
                         ->findOneBy(['name' => $status->getStatus()]);
        $payment->setState($newState);

        if ($previousState != $payment->getState()) {
            $this->dispatchEvent(
                SyliusPaymentEvents::PRE_STATE_CHANGE,
                new GenericEvent($order->getPayment(), array('previous_state' => $previousState))
            );

            //Dispatch shipping step events
            $this->dispatchCheckoutEvent(SyliusCheckoutEvents::SHIPPING_PRE_COMPLETE, $order);
        }

        $this->getDoctrine()->getManager()->flush();

        if ($previousState != $payment->getState()) {
            $this->dispatchEvent(
                SyliusPaymentEvents::POST_STATE_CHANGE,
                new GenericEvent($order->getPayment(), array('previous_state' => $previousState))
            );          
            
        }

        $event = new PurchaseCompleteEvent($order->getPayment());
        $this->dispatchEvent(SyliusCheckoutEvents::PURCHASE_COMPLETE, $event);

        //Dispatch shipping step events
        $this->dispatchCheckoutEvent(SyliusCheckoutEvents::SHIPPING_COMPLETE, $order);
        $this->dispatchCheckoutEvent(SyliusAutoPayEvents::POST_CREATE, $order);

        if ($event->hasResponse()) {
            return $event->getResponse();
        }

        return $this->complete();
    }

    /**
     * @return RegistryInterface
     */
    protected function getPayum()
    {
        return $this->get('payum');
    }

    /**
     * @return TokenFactory
     */
    protected function getTokenFactory()
    {
        return $this->get('payum.security.token_factory');
    }

    /**
     * @return HttpRequestVerifierInterface
     */
    protected function getHttpRequestVerifier()
    {
        return $this->get('payum.security.http_request_verifier');
    }
}
