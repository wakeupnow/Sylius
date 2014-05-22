<?php

namespace Wun\Iris\LegacyBundle\Tests;

require_once __DIR__ . '../../../../../../app/AppKernel.php';


/**
 * Class KernelAwareHelper
 * @package Wun\Iris\LegacyBundle\Tests
 */
trait KernelAwareTrait
{
    protected static $container;

    public function setUp()
    {
        self::$kernel = new \AppKernel('test', true);
        self::$kernel->boot();

        self::$container = self::$kernel->getContainer();
    }

    public function get($serviceId)
    {
        return self::$kernel->getContainer()->get($serviceId);
    }

    /**
     * @param $name
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function em($name = 'legacy')
    {
        return $this->getDoctrine()->getManager($name);
    }

    /**
     * @param string $entity Entity class
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository($entity)
    {
        return $this->getDoctrine()->getRepository($entity);
    }

    /**
     * Persist passed entities
     */
    protected function persist($arg, $overrideIdGenerator = false)
    {
        $em = $this->em();

        $entities = is_array($arg) ? $arg : func_get_args();
        foreach ($entities as $entity) {
            $em->persist($entity);
        }

        $em->flush();

        return $this;
    }

    /**
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    protected function getDoctrine()
    {
        return $this->get('doctrine');
    }

    /**
     * @return \Symfony\Component\Validator\Validator
     */
    protected function getValidator()
    {
        return $this->get('validator');
    }

    /**
     * @param object $object
     * @param string $property
     * @return bool
     */
    protected function isPropertyValid($object, $property)
    {
        $violations = $this->getValidator()->validate($object);
        foreach ($violations as $violation) {
            /** @var \Symfony\Component\Validator\ConstraintViolation $violation */
            if ($violation->getPropertyPath() == $property) {
                return false;
            }
        }

        return true;
    }
}
