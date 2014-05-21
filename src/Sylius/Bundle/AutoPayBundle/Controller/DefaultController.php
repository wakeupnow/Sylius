<?php

namespace Sylius\Bundle\AutoPayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SyliusAutoPayBundle:Default:index.html.twig', array('name' => $name));
    }
}
