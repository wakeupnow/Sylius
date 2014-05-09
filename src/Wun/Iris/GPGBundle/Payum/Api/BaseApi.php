<?php

namespace Wun\Iris\GPGBundle\Payum\Api;

use Payum\Core\Exception\InvalidArgumentException;

/**
 * Description of Api
 *
 * @author kiser
 */
abstract class BaseApi {

    /**
     * @var SoapClientFactory
     */
    protected $clientFactory;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param SoapClientFactory $clientFactory
     * @param array $options
     *
     * @throws \Payum\Core\Exception\InvalidArgumentException if an option is invalid
     */
    public function __construct($clientFactory, array $options)
    {
        $this->clientFactory = $clientFactory;
        $this->options = $options;

        if (true == empty($this->options['apiusername'])) {
            throw new InvalidArgumentException('The apiusername option must be set.');
        }

        if (true == empty($this->options['apipassword'])) {
            throw new InvalidArgumentException('The apipassword option must be set.');
        }

        if (false == is_bool($this->options['sandbox'])) {
            throw new InvalidArgumentException('The boolean sandbox option must be set.');
        }
    }

    /**
     * @param string $operation
     * @param array $parameters
     * @param string $serviceWsdl
     *
     * @return array
     */
    protected function call($operation, array $parameters, $serviceWsdl)
    {
        $client = $this->clientFactory->createWsdlClient($serviceWsdl);

        $result = @$client->$operation($parameters);
        $result = objectToArray($result);

        return $result;
    }    

    protected function objectToArray($d) {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }
        if (is_array($d)) {
            returnarray_map(__FUNCTION__, $d);
        } else {
            return $d;
        }
    }
}