<?php
namespace Wun\Iris\GPGBundle\Payum\Action;

use Wun\Iris\GPGBundle\Payum\Api\Api;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Request\StatusRequestInterface;
use Payum\Core\Exception\RequestNotSupportedException;

class StatusAction implements ActionInterface
{

    /**
    * {@inheritdoc}
    */
    public function execute($request)
    {
        /** @var $request StatusRequestInterface */
        if (false == $this->supports($request)) {
            throw RequestNotSupportedException::createActionNotSupported($this, $request);
        }

        $model = new ArrayObject($request->getModel());

        if (!isset($model['ResponsePayout']['Response'])) {
            $request->markNew();

            return;
        }

        if ( isset($model['ResponsePayout']['Response']) && Api::GPG_PAYOUT_SUCCESS === $model['ResponsePayout']['Response']) {
            $request->markSuccess();

            return;
        }
//TODO: Have to get more infor from GPG api to set time out action.
//        if (Api::EXECCODE_TIME_OUT  === $model['EXECCODE']) {
//            $request->markUnknown();
//
//            return;
//        }

        $request->markFailed();
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request)
    {
        return
            $request instanceof StatusRequestInterface &&
            $request->getModel() instanceof \ArrayAccess
        ;
    }
}
