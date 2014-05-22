<?php

namespace Wun\Iris\LegacyBundle\Tests\Entity;

use Wun\Iris\LegacyBundle\Tests\DummyEntitiesTrait;
use Wun\Iris\LegacyBundle\Tests\KernelAwareIntegrationTest;

class EntityCrudTest extends KernelAwareIntegrationTest
{
    use DummyEntitiesTrait;

    private $member;
    private $balance;

    public function setUp()
    {
        parent::setUp();

        $this->member = $this->loadEntity('Member');
        $this->balance = $this->loadEntity('Balance');
    }

    public function tearDown()
    {
        if($this->member || $this->balance)
        {
            $this->em()->remove(($this->member) ?: $this->balance);
            $this->em()->flush();
        }
    }

    private function loadEntity($type)
    {
        return ($type == 'Member') ?
            $this
                ->em()
                ->getRepository('WunIrisLegacyBundle:Members')
                ->findOneByUsername('testMember') :
            $this
                ->em()
                ->getRepository('WunIrisLegacyBundle:Memberbalances')
                ->findOneByOriginalbalance(12345);
    }

    public function testCreateMember()
    {
        $this->member = $this->createDummyMember();

        $this->persist($this->member);

        $testEntity = $this->loadEntity('Member');

        $this->assertInstanceOf('Wun\Iris\LegacyBundle\Entity\Members', $testEntity);
        $this->assertNotEmpty($testEntity->getPassword());
    }

    public function testDeleteMember()
    {
        if(empty($this->member))
        {
            $this->member = $this->createDummyMember();

            $this->persist($this->member);
        }

        $this->em()->remove($this->member);
        $this->em()->flush();

        $testEntity = $this->loadEntity('Member');

        $this->assertEmpty($testEntity);
    }

    public function testCreateBalance()
    {
        $this->balance = $this->createDummyBalance();

        $this->persist($this->balance);

        $testEntity = $this->loadEntity('Balance');

        $this->assertInstanceOf('Wun\Iris\LegacyBundle\Entity\Memberbalances', $testEntity);
        $this->assertNotEmpty($testEntity->getDateTimePosted());
    }

    public function testDeleteBalance()
    {
        if(empty($this->balance))
        {
            $this->balance = $this->createDummyBalance();

            $this->persist($this->balance);
        }

        $this->em()->remove($this->balance);
        $this->em()->flush();

        $testEntity = $this->loadEntity('Balance');

        $this->assertEmpty($testEntity);
    }
}
