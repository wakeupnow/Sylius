<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\AutoPay;

class SyliusAutoPayEvents
{
    const PRE_CREATE  = 'sylius.auto_pay.pre_create';
    const POST_CREATE = 'sylius.auto_pay.post_create';

    const PRE_UPDATE  = 'sylius.auto_pay.pre_update';
    const POST_UPDATE = 'sylius.auto_pay.post_update';

    const PRE_DELETE  = 'sylius.auto_pay.pre_delete';
    const POST_DELETE = 'sylius.auto_pay.post_delete';
}
