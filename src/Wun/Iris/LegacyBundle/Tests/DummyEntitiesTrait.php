<?php

namespace Wun\Iris\LegacyBundle\Tests;

use Wun\Iris\LegacyBundle\Entity\Members;
use Wun\Iris\LegacyBundle\Entity\MemberBalances;

/**
 * Class DummyEntities
 * @package Wun\Iris\LegacyBundle\Tests
 */
trait DummyEntitiesTrait
{
    /**
     * @return Members
     */
    protected function createDummyMember()
    {
        $member = new Members();

        $member
            ->setId(13371337)
            ->setUserName('testMember')
            ->setPassword('testpass');

        return $member;
    }

    /**
     * @return MemberBalances
     */
    protected function createDummyBalance()
    {
        $balance = new MemberBalances();

        $balance
            ->setMemberID(1)
            ->setDateTimePosted(new \DateTime())
            ->setOriginalBalance(12345)
            ->setAmountTransacted(1)
            ->setBalanceType(1)
            ->setReceiptID(1);

        return $balance;
    }
}
