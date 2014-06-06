<?php

/*
* This file is part of the Sylius package.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sylius\Bundle\PayumBundle\Payum\Action;

use Payum\Bundle\PayumBundle\Request\ResponseInteractiveRequest;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Exception\LogicException;
use Payum\Core\Exception\RequestNotSupportedException;
use Sylius\Bundle\PayumBundle\Payum\Request\ObtainCreditCardRequest;
use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ObtainCreditCardAction implements ActionInterface
{
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var Request
     */
    protected $httpRequest;

    /**
     * @var null|ZoneInterface
     */
    private $zones;

    /** @var ContainerInterface */
    protected $container;

    /**
     * @param FormFactoryInterface $formFactory
     * @param EngineInterface      $templating
     */
    public function __construct(FormFactoryInterface $formFactory, EngineInterface $templating, ContainerInterface $container)
    {
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->container = $container;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request = null)
    {
        $this->httpRequest = $request;
    }

    /**
     * {@inheritDoc}
     */
    public function execute($request)
    { 
        /** @var $request ObtainCreditCardRequest */
        if (!$this->supports($request)) {
            throw RequestNotSupportedException::createActionNotSupported($this, $request);
        }
        if (!$this->httpRequest) {
            throw new LogicException('The action can be run only when http request is set.');
        }

        $order = $request->getOrder();
        $form = $this->createCreditCardForm($order);
        $shippingForm = $this->createCheckoutShippingForm($order);
        
        if ($this->httpRequest->isMethod('POST') && $form->isValid()) {
            $form->submit($this->httpRequest);
            $request->setCreditCard($form->getData());
            //TODO: Have to add shipping with order object after changes the model.
            return;
        }

        throw new ResponseInteractiveRequest(new Response(
            $this->templating->render('SyliusPayumBundle::Payum\Action\obtainCreditCard.html.twig', array(
                'form' => $form->createView(),
                'shippingForm' => $shippingForm->createView(),
                'order' => $order,
            ))
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return $request instanceof ObtainCreditCardRequest;
    }

    /**
     * @return FormInterface
     */
    protected function createCreditCardForm($order)
    {        

        return $this->formFactory->create('sylius_credit_card');
    }

    protected function createCheckoutShippingForm(OrderInterface $order)
    {
        $this->zones = $this->getZoneMatcher()->matchAll($order->getShippingAddress());

        if (empty($this->zones)) {
            $this->container->get('session')->getFlashBag()->add('error', 'sylius.checkout.shipping.error');
        }

        return $this->formFactory->create('sylius_checkout_shipping', $order, array(
            'criteria' => array('zone' => !empty($this->zones) ? array_map(function ($zone) {
                return $zone->getId();
            }, $this->zones) : null)
        ));
    }

    /**
     * Get zone matcher.
     *
     * @return ZoneMatcherInterface
     */
    protected function getZoneMatcher()
    {
        return $this->container->get('sylius.zone_matcher');
    }
}
