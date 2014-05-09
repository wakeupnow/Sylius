<?php

namespace Wun\Iris\GPGBundle\Payum\Api;

class Api extends BaseApi
{

    const VERSION = '1.0';

    const GPG_PAYOUT_SUCCESS = 'Success';

    const GPG_PAYOUT_ERROR = 'ERROR';

    public function instantSubmitPayoutRequest(array $parameters)
    {
        return $this->call('InstantSubmitPayoutRequest', $parameters, $this->getGPGWsdl());
    }

    /**
     * {@inheritDoc}
     */
    public function getGPGWsdl()
    {
        return $this->options['sandbox'] ?
            'http://demo.gpgway.com/gpgclientapi.asmx?WSDL' :
            'https://www.gpgway.com/GPGClientAPI.asmx?WSDL'
        ;
    }

}
