<?php

/*
* This file is part of the Sylius package.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace spec\Sylius\Bundle\CoreBundle\Checkout\Step;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Payum\Core\PaymentInterface;
use Payum\Core\Registry\RegistryInterface;
use Payum\Core\Security\HttpRequestVerifierInterface;
use Payum\Core\Security\TokenInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\Sylius\Bundle\CoreBundle\Fixture\RequestStack;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Component\Cart\Provider\CartProviderInterface;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Core\SyliusCheckoutEvents;
use Sylius\Component\Payment\Model\Payment;
use Sylius\Component\Payment\Model\PaymentState;
use Sylius\Component\Payment\SyliusPaymentEvents;
use Symfony\Bridge\Doctrine\RegistryInterface as DoctrinRegistryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\TranslatorInterface;

require_once __DIR__.'/../../Fixture/RequestStack.php';

class PurchaseStepSpec extends ObjectBehavior
{
    function let(
        ContainerInterface $container,
        HttpRequestVerifierInterface $httpRequestVerifier,
        TokenInterface $token,
        Request $request,
        RequestStack $requestStack,
        CartProviderInterface $cartProvider,
        RegistryInterface $payum,
        PaymentInterface $payment,
        EventDispatcherInterface $eventDispatcher,
        DoctrinRegistryInterface $doctrine,
        ObjectManager $objectManager,
        ObjectRepository $paymentStateRepository,
        Session $session,
        FlashBagInterface $flashBag,
        TranslatorInterface $translator
    ) {
        $requestStack->getCurrentRequest()->willReturn($request);
        $session->getFlashBag()->willReturn($flashBag);
        $token->getPaymentName()->willReturn('aPaymentName');
        $payum->getPayment('aPaymentName')->willReturn($payment);
        $httpRequestVerifier->verify($request)->willReturn($token);
        $httpRequestVerifier->invalidate($token)->willReturn(null);

        $doctrine->getManager()->willReturn($objectManager);
        $objectManager->getRepository('Sylius\Component\Payment\Model\PaymentState')
                      ->willReturn($paymentStateRepository);
        $paymentStateRepository->findOneBy(Argument::any())->will(function($args) {
            return new PaymentState($args[0]['name']);
        });

        $container->get('payum.security.http_request_verifier')->willReturn($httpRequestVerifier);
        $container->get('request')->willReturn($request);
        $container->get('request_stack')->willReturn($requestStack);
        $container->get('sylius.cart_provider')->willReturn($cartProvider);
        $container->get('payum')->willReturn($payum);
        $container->get('event_dispatcher')->willReturn($eventDispatcher);
        $container->get('session')->willReturn($session);
        $container->get('doctrine')->willReturn($doctrine);
        $container->has('doctrine')->willReturn(true);
        $container->get('translator')->willReturn($translator);

        $this->setName('purchase');

        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\CoreBundle\Checkout\Step\PurchaseStep');
    }

    function it_extends_checkout_step()
    {
        $this->shouldImplement('Sylius\Bundle\CoreBundle\Checkout\Step\CheckoutStep');
    }

    function it_must_dispatch_pre_and_post_payment_state_changed_if_state_changed(
        ProcessContextInterface $context,
        PaymentInterface $payment,
        EventDispatcherInterface $eventDispatcher,
        ObjectManager $objectManager
    ) {
        $paymentModel = new Payment();
        $paymentModel->setState(new PaymentState(PaymentState::CREATED));
        $order = new Order();
        $order->setPayment($paymentModel);

        $objectManager->flush()->shouldBeCalled();

        $payment
            ->execute(Argument::type('Sylius\Bundle\PayumBundle\Payum\Request\StatusRequest'))
            ->will(function ($args) use ($order, $paymentModel) {
                $args[0]->markSuccess();
                $args[0]->setModel($order);
            }
        );

        $eventDispatcher
            ->dispatch(
                SyliusPaymentEvents::PRE_STATE_CHANGE,
                Argument::type('Symfony\Component\EventDispatcher\GenericEvent')
            )
            ->shouldBeCalled()
        ;
        $eventDispatcher
            ->dispatch(
                SyliusPaymentEvents::POST_STATE_CHANGE,
                Argument::type('Symfony\Component\EventDispatcher\GenericEvent')
            )
            ->shouldBeCalled()
        ;

        $eventDispatcher
            ->dispatch(
                SyliusCheckoutEvents::PURCHASE_COMPLETE,
                Argument::type('Sylius\Bundle\CoreBundle\Event\PurchaseCompleteEvent')
            )
            ->shouldBeCalled()
        ;

        $this->forwardAction($context)->shouldReturnAnInstanceOf('Sylius\Bundle\FlowBundle\Process\Step\ActionResult');
    }

    function it_must_not_dispatch_pre_and_post_payment_state_changed_if_state_not_changed(
        ProcessContextInterface $context,
        PaymentInterface $payment,
        EventDispatcherInterface $eventDispatcher,
        ObjectManager $objectManager
    ) {
        $paymentModel = new Payment();
        $paymentModel->setState(new PaymentState(PaymentState::COMPLETED));
        $order = new Order();
        $order->setPayment($paymentModel);

        $objectManager->flush()->shouldBeCalled();

        $payment
            ->execute(Argument::type('Sylius\Bundle\PayumBundle\Payum\Request\StatusRequest'))
            ->will(function ($args) use ($order, $paymentModel) {
                    $args[0]->markSuccess();
                    $args[0]->setModel($order);
                }
            );

        $eventDispatcher
            ->dispatch(
                SyliusPaymentEvents::PRE_STATE_CHANGE,
                Argument::type('Symfony\Component\EventDispatcher\GenericEvent')
            )
            ->shouldNotBeCalled()
        ;
        $eventDispatcher
            ->dispatch(
                SyliusPaymentEvents::POST_STATE_CHANGE,
                Argument::type('Symfony\Component\EventDispatcher\GenericEvent')
            )
            ->shouldNotBeCalled()
        ;
        $eventDispatcher
            ->dispatch(
                SyliusCheckoutEvents::PURCHASE_COMPLETE,
                Argument::type('Sylius\Bundle\CoreBundle\Event\PurchaseCompleteEvent')
            )
            ->shouldBeCalled()
        ;

        $this->forwardAction($context)->shouldReturnAnInstanceOf('Sylius\Bundle\FlowBundle\Process\Step\ActionResult');
    }
}
