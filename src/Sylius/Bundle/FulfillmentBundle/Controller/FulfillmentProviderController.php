<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\FulfillmentBundle\Controller;

use Doctrine\Common\Persistence\ObjectRepository;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Fulfillment Provider controller.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@sylius.pl>
 */
class FulfillmentProviderController extends ResourceController
{
    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        /*if (null === $taxonomyId = $this->getRequest()->get('taxonomyId')) {
            throw new NotFoundHttpException('No taxonomy id given.');
        }

        if (!$taxonomy = $this->getTaxonomyRepository()->find($taxonomyId)) {
            throw new NotFoundHttpException('Requested taxonomy does not exist.');
        }*/
        $fulfillment = parent::createNew();
        //$fulfillment->setTaxonomy($taxonomy);

        return $fulfillment;
    }

    /**
     * Get fulfillment repository.
     *
     * @return ObjectRepository
     */
    protected function getFulfillmentProviderRepository()
    {
        return $this->get('sylius.repository.fulfillment_provider');
    }

    /**
     * Create new fulfillment provider.
     */
    /*public function createAction(Request $request)
    {
        $user = $this->getUser();
        $address = $this->getAddressRepository()->createNew();
        $form = $this->getAddressForm($address);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $user->addAddress($address);

            $manager = $this->getUserManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'sylius.account.address.create');

            return $this->redirectToIndex();
        }

        return $this->render('SyliusWebBundle:Frontend/Account:Address/create.html.twig', array(
            'user' => $this->getUser(),
            'form' => $form->createView()
        ));
    }*/
}
