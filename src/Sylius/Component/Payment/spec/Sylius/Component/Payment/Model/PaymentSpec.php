<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Component\Payment\Model;

use PhpSpec\ObjectBehavior;
use Sylius\Component\Payment\Model\CreditCardInterface;
use Sylius\Component\Payment\Model\PaymentState;
use Sylius\Component\Payment\Model\PaymentInterface;
use Sylius\Component\Payment\Model\PaymentGatewayInterface;

/**
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PaymentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Component\Payment\Model\Payment');
    }

    function it_implements_Sylius_payment_interface()
    {
        $this->shouldImplement('Sylius\Component\Payment\Model\PaymentInterface');
    }

    function it_has_no_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_has_no_payment_gateway_by_default()
    {
        $this->getMethod()->shouldReturn(null);
    }

    function its_payment_gateway_is_mutable(PaymentGatewayInterface $method)
    {
      $this->setMethod($method);
      $this->getMethod()->shouldReturn($method);
    }

    function it_has_no_source_by_default()
    {
        $this->getSource()->shouldReturn(null);
    }

    function it_allows_to_assign_a_source(CreditCardInterface $source)
    {
        $this->setSource($source);
        $this->getSource()->shouldReturn($source);
    }

    function it_allows_to_remove_a_source(CreditCardInterface $source)
    {
        $this->setSource($source);
        $this->setSource(null);
        $this->getSource()->shouldReturn(null);
    }

    function it_has_no_currency_by_default()
    {
        $this->getCurrency()->shouldReturn(null);
    }

    function its_currency_is_mutable()
    {
        $this->setCurrency('EUR');
        $this->getCurrency()->shouldReturn('EUR');
    }

    function it_has_amount_equal_to_0_by_default()
    {
        $this->getAmount()->shouldReturn(0);
    }

    function its_amount_is_mutable()
    {
        $this->setAmount(4999);
        $this->getAmount()->shouldReturn(4999);
    }

    function it_has_no_state_by_default()
    {
        $this->getState()->shouldReturn(null);
    }

    function its_state_is_mutable()
    {
        $this->setState($state = new PaymentState(PaymentState::COMPLETED));
        $this->getState()->shouldReturn($state);
    }

    function it_initializes_creation_date_by_default()
    {
        $this->getCreatedAt()->shouldHaveType('DateTime');
    }

    function its_creation_date_is_mutable()
    {
        $date = new \DateTime('last year');

        $this->setCreatedAt($date);
        $this->getCreatedAt()->shouldReturn($date);
    }

    function it_has_no_last_update_date_by_default()
    {
        $this->getUpdatedAt()->shouldReturn(null);
    }

    function its_last_update_date_is_mutable()
    {
        $date = new \DateTime('last year');

        $this->setUpdatedAt($date);
        $this->getUpdatedAt()->shouldReturn($date);
    }
}
