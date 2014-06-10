<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Addressing\Model;

use Wun\Shared\DomainModelsBundle\Entity\Address as WunAddress;

/**
 * Default address model.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@sylius.pl>
 */
class Address extends WunAddress implements AddressInterface
{
    /**
     * @var string
     */
    protected $company;

    /**
     * @var string
     */
    protected $state;

    /**
     * Get first name.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->getContact() ? $this->getContact()->getFirstName() : null;
    }

    /**
     * Set first name.
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        if (!$this->getContact()) {
            $this->setContact(new \Wun\Shared\DomainModelsBundle\Entity\Contact());
        }
        $this->getContact()->setFirstName($firstName);
    }

    /**
     * Get last name.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->getContact() ? $this->getContact()->getLastName() : null;
    }

    /**
     * Set last name.
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        if (!$this->getContact()) {
            $this->setContact(new \Wun\Shared\DomainModelsBundle\Entity\Contact());
        }
        $this->getContact()->setLastName($lastName);
    }

    /**
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Get province.
     *
     * @return ProvinceInterface $province
     */
    public function getProvince()
    {
        return $this->getRegion();
    }

    /**
     * Set province.
     *
     * @param ProvinceInterface $province
     */
    public function setProvince(ProvinceInterface $province = null)
    {
        $this->setRegion($province);
    }

    /**
     * Get street.
     *
     * @return string
     */
    public function getStreet()
    {
        $this->getStreet1();
    }

    /**
     * Set street.
     *
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->setStreet1($street);
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
       return $this->getStreet1();
    }

    /**
     * @param $address
     */
    public function setAddress1($address)
    {
        $this->setStreet1($address);
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
       return $this->getStreet2();
    }

    /**
     * @param $address
     */
    public function setAddress2($address)
    {
        $this->setStreet2($address);
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }
}
