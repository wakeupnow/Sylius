<?php

namespace Wun\Iris\LegacyBundle\Tests;

/**
 * Class KernelAwareIntegrationTest
 * @package Rc\Bundle\CoreBundle\Tests
 */
class KernelAwareIntegrationTest extends \PHPUnit_Framework_TestCase
{
    protected static $kernel;
    use KernelAwareTrait;
}
