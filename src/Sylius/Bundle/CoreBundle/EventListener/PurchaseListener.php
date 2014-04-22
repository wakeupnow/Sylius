<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\CoreBundle\EventListener;

use Sylius\Bundle\CoreBundle\Event\PurchaseCompleteEvent;
use Sylius\Component\Cart\Provider\CartProviderInterface;
use Sylius\Component\Payment\Model\PaymentState;
use Sylius\Component\Payment\Model\PaymentInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

class PurchaseListener
{
    protected $cartProvider;
    protected $router;
    protected $session;
    protected $translator;
    protected $redirectTo;

    public function __construct(CartProviderInterface $cartProvider, UrlGeneratorInterface $router, SessionInterface $session, TranslatorInterface $translator, $redirectTo)
    {
        $this->cartProvider = $cartProvider;
        $this->router = $router;
        $this->session = $session;
        $this->translator = $translator;
        $this->redirectTo = $redirectTo;
    }

    public function abandonCart(PurchaseCompleteEvent $event)
    {
        if (in_array($event->getSubject()->getState(), array(PaymentState::PENDING, PaymentState::PROCESSING, PaymentState::COMPLETED))) {
            $this->cartProvider->abandonCart();

            return;
        }

        $event->setResponse(new RedirectResponse(
            $this->router->generate($this->redirectTo)
        ));
    }

    public function addFlash(PurchaseCompleteEvent $event)
    {
        switch ($event->getSubject()->getState()) {
            case PaymentState::COMPLETED:
                $type = 'success';
                $message = 'sylius.checkout.success';
                break;

            case PaymentState::PROCESSING:
            case PaymentState::PENDING:
                $type = 'notice';
                $message = 'sylius.checkout.processing';
                break;

            case PaymentState::VOID:
                $type = 'notice';
                $message = 'sylius.checkout.canceled';
                break;

            case PaymentState::FAILED:
                $type = 'error';
                $message = 'sylius.checkout.failed';
                break;

            default:
                $type = 'error';
                $message = 'sylius.checkout.unknown';
                break;
        }

        $this->session->getBag('flashes')->add(
            $type,
            $this->translator->trans($message, array(), 'flashes')
        );
    }
}
