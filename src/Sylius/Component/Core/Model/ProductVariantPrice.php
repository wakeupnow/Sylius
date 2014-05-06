<?php

namespace Sylius\Component\Core\Model;

use Wun\Shared\DomainModelsBundle\Entity\AccountType;

/**
 * Class ProductVariantPrice
 * @package Sylius\Component\Core\Model
 */
class ProductVariantPrice implements ProductVariantPriceInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var PriceTypeInterface
     */
    private $type;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var ProductVariantInterface
     */
    private $variant;

    /**
     * @var AccountType[]
     */
    private $accountTypes;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Wun\Shared\DomainModelsBundle\Entity\AccountType[] $accountTypes
     */
    public function setAccountTypes(array $accountTypes)
    {
        $this->accountTypes = $accountTypes;
    }

    /**
     * @return \Wun\Shared\DomainModelsBundle\Entity\AccountType[]
     */
    public function getAccountTypes()
    {
        return $this->accountTypes;
    }

    /**
     * @param AccountType $accountType
     */
    public function addAccountType(AccountType $accountType)
    {
        if (!in_array($accountType, $this->accountTypes)) {
            $this->accountTypes[] = $accountType;
        }
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param \Sylius\Component\Core\Model\PriceTypeInterface $type
     */
    public function setType(PriceTypeInterface $type)
    {
        $this->type = $type;
    }

    /**
     * @return \Sylius\Component\Core\Model\PriceTypeInterface
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param \Sylius\Component\Core\Model\ProductVariantInterface $variant
     */
    public function setVariant(ProductVariantInterface $variant)
    {
        $this->variant = $variant;
    }

    /**
     * @return \Sylius\Component\Core\Model\ProductVariantInterface
     */
    public function getVariant()
    {
        return $this->variant;
    }
}
