<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\MoneyBundle\Twig;

use Sylius\Component\Money\Context\CurrencyContextInterface;
use Sylius\Component\Money\Converter\CurrencyConverterInterface;

/**
 * Sylius money Twig helper.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SyliusMoneyExtension extends \Twig_Extension
{
    protected $currencyContext;
    protected $formatter;
    protected $converter;

    public function __construct(CurrencyContextInterface $currencyContext, CurrencyConverterInterface $converter, $locale = null)
    {
        $this->currencyContext = $currencyContext;
        $this->converter       = $converter;
        $this->formatter       = new \NumberFormatter($locale ?: \Locale::getDefault(), \NumberFormatter::CURRENCY);
        $this->formatter->setPattern("¤#,##0.00;-¤#,##0.00");
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('sylius_money', array($this, 'formatMoney'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('sylius_price', array($this, 'formatPrice'), array('is_safe' => array('html'))),
        );
    }

    /**
     * Format the money amount to nice display form.
     *
     * @param integer     $amount
     * @param string|null $currency
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function formatMoney($amount, $currency = null)
    {
        $currency = $currency ?: $this->currencyContext->getDefaultCurrency();
        $result   = $this->formatter->formatCurrency($amount / 100, $currency);

        if (false === $result) {
            throw new \InvalidArgumentException(sprintf('The amount "%s" of type %s cannot be formatted to currency "%s".', $amount, gettype($amount), $currency));
        }

        return str_replace(' ', ' ', $result);
    }

    /**
     * Convert price between currencies and format the amount to nice display form.
     *
     * @param integer|array     $amount
     * @param string|null $currency
     *
     * @return string
     */
    public function formatPrice($amount, $currency = null)
    {
        if ($amount instanceof \Doctrine\ORM\PersistentCollection) {
            $amount = $amount->toArray();
        }

        if (is_array($amount)) {
            if (count($amount)) {
                foreach ($amount as $price) {

                    /** @var \Sylius\Component\Core\Model\ProductVariantPriceInterface $price */
                    if ($price->getType() == 'MSRP') {
                        $amount = $price->getAmount();
                        break;
                    }
                }
            }
            else {
                $amount = 0;
            }
        }

        $currency = $currency ?: $this->currencyContext->getCurrency();
        $amount   = $this->converter->convert($amount, $currency);

        return $this->formatMoney($amount, $currency);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_money';
    }
}
