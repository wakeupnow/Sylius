<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\FulfillmentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Sylius\Component\Fulfillment\Model\FulfillmentProvider;

/**
 * Command to purge expired carts
 *
 * @author Alexandre Bacco <alexandre.bacco@gmail.com>
 */
class FulfillmentProcessCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sylius:fulfillment:process')
            ->setDescription('Executes fulfillment processing')
            ->addArgument('fp_ids', InputArgument::OPTIONAL, 'Comma separated list of fulfillment provider IDs to process.');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var FulfillmentProvider $fp */
        $fp = $this->getContainer()->get('sylius_fulfillment.fulfillment_provider');
        /** @var EntityMan $fp */
        $em = $this->getHelper('em')->getEntityManager();
        //$em = $this->get
        var_dump($em);

        die;
        //$cartsPurger = $this->getContainer()->get('sylius.cart.purger');
        //cartsPurger->purge();

        $output->writeln('Expired carts purged.');
    }
}