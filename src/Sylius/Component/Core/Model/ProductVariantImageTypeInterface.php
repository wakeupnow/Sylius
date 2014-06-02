<?php

namespace Sylius\Component\Core\Model;

interface ProductVariantImageTypeInterface
{
    public function getId();

    public function getName();

    public function setName($name);
}
