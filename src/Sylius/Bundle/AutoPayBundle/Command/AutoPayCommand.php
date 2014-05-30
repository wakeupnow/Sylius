<?php

/*
 * This file is part of the Sylius package.
*
* (c) Wun
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sylius\Bundle\AutoPayBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to release expired pending orders
 *
 * @author Abdullah Kiser <kiser.bd@gmail.com>
 */

class AutoPayCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sylius:auto:pay')
            ->setDescription('AutoPay or auto order of products')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $autoPayManager = $this->getContainer()->get('sylius.auto_pay.manager');
        $autoPayManager->placeAutoPayOrder();
        $output->writeln('Orders done!');
    }
}