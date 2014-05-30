<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Wun
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\AutoPayBundle\Controller;

use Doctrine\Common\Persistence\ObjectRepository;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Addressing\Model\CountryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * Description of IntervalController
 *
 * @author Abdullah kiser<kiser.bd@gmail.com>
 */

class AutoPayController extends ResourceController
{

}