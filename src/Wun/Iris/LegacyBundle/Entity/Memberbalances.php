<?php

namespace Wun\Iris\LegacyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Memberbalances
 *
 * @ORM\Table(name="memberBalances", indexes={@ORM\Index(name="memberID", columns={"memberID"})})
 * @ORM\Entity
 */
class Memberbalances
{
    /**
     * @var integer
     *
     * @ORM\Column(name="balanceID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $balanceid;

    /**
     * @var integer
     *
     * @ORM\Column(name="memberID", type="integer", nullable=false)
     */
    private $memberid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTimePosted", type="datetime", nullable=false)
     */
    private $datetimeposted;

    /**
     * @var string
     *
     * @ORM\Column(name="originalBalance", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $originalbalance;

    /**
     * @var string
     *
     * @ORM\Column(name="amountTransacted", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $amounttransacted;

    /**
     * @var integer
     *
     * @ORM\Column(name="balanceType", type="integer", nullable=false)
     */
    private $balancetype;

    /**
     * @var string
     *
     * @ORM\Column(name="receiptID", type="string", length=15, nullable=false)
     */
    private $receiptid;



    /**
     * Get balanceid
     *
     * @return integer 
     */
    public function getBalanceid()
    {
        return $this->balanceid;
    }

    /**
     * Set memberid
     *
     * @param integer $memberid
     * @return Memberbalances
     */
    public function setMemberid($memberid)
    {
        $this->memberid = $memberid;

        return $this;
    }

    /**
     * Get memberid
     *
     * @return integer 
     */
    public function getMemberid()
    {
        return $this->memberid;
    }

    /**
     * Set datetimeposted
     *
     * @param \DateTime $datetimeposted
     * @return Memberbalances
     */
    public function setDatetimeposted($datetimeposted)
    {
        $this->datetimeposted = $datetimeposted;

        return $this;
    }

    /**
     * Get datetimeposted
     *
     * @return \DateTime 
     */
    public function getDatetimeposted()
    {
        return $this->datetimeposted;
    }

    /**
     * Set originalbalance
     *
     * @param string $originalbalance
     * @return Memberbalances
     */
    public function setOriginalbalance($originalbalance)
    {
        $this->originalbalance = $originalbalance;

        return $this;
    }

    /**
     * Get originalbalance
     *
     * @return string 
     */
    public function getOriginalbalance()
    {
        return $this->originalbalance;
    }

    /**
     * Set amounttransacted
     *
     * @param string $amounttransacted
     * @return Memberbalances
     */
    public function setAmounttransacted($amounttransacted)
    {
        $this->amounttransacted = $amounttransacted;

        return $this;
    }

    /**
     * Get amounttransacted
     *
     * @return string 
     */
    public function getAmounttransacted()
    {
        return $this->amounttransacted;
    }

    /**
     * Set balancetype
     *
     * @param integer $balancetype
     * @return Memberbalances
     */
    public function setBalancetype($balancetype)
    {
        $this->balancetype = $balancetype;

        return $this;
    }

    /**
     * Get balancetype
     *
     * @return integer 
     */
    public function getBalancetype()
    {
        return $this->balancetype;
    }

    /**
     * Set receiptid
     *
     * @param string $receiptid
     * @return Memberbalances
     */
    public function setReceiptid($receiptid)
    {
        $this->receiptid = $receiptid;

        return $this;
    }

    /**
     * Get receiptid
     *
     * @return string 
     */
    public function getReceiptid()
    {
        return $this->receiptid;
    }
}
