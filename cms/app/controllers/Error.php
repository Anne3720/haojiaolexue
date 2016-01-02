<?php

class ErrorController extends RThink_Controller_Action
{

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');

        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->data['message'] = 'You have reached the error page';
            return;
        }


        switch ($errors->type) {
            case RThink_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case RThink_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case RThink_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- Controller or action not found
                $this->getResponse()->setHttpResponseCode(404);

                $this->view->data['message'] = '页面找不到';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->data['message'] = '应用错误';
                break;
        }


        // conditionally display exceptions
        if (RThink_Config::get('app.debug') && RThink_Config::get('app.display_exceptions') == true) {
            $this->view->data['exception'] = $errors->exception;
        }

           $this->view->data['request'] = $errors->request;

        $this->render($this->view->data);
    }


}

