<?php

namespace Sylius\Component\Core\Model;

use Wun\Shared\DomainModelsBundle\Entity\AccountType;

/**
 * Interface ProductVariantPriceInterface
 * @package Sylius\Component\Core\Model
 */
interface ProductVariantPriceInterface extends PriceInterface
{
    /**
     * @return PriceTypeInterface
     */
    public function getType();

    /**
     * @param PriceTypeInterface $priceType
     */
    public function setType(PriceTypeInterface $priceType);

    /**
     * @return ProductVariantInterface
     */
    public function getVariant();

    /**
     * @param ProductVariantInterface $variant
     */
    public function setVariant(ProductVariantInterface $variant);

    /**
     * @return AccountType
     */
    public function getAccountTypes();

    /**
     * @param AccountType[] $accountTypes
     */
    public function setAccountTypes(array $accountTypes);

    /**
     * @param AccountType $accountType
     */
    public function addAccountType(AccountType $accountType);

    /**
     * @param AccountType $accountType
     */
    public function removeAccountType(AccountType $accountType);
}
