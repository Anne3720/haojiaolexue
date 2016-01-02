<?php
/**
 * Handle exceptions that bubble up based on missing controllers, actions, or
 * application errors, and forward to an error handler.
 *
 * @uses       RThink_Controller_Plugin_Abstract
 */
class RThink_Controller_Plugin_ErrorHandler extends RThink_Controller_Plugin_Abstract
{
    /**
     * Const - No Controller exception; Controller does not exist
     */
    const EXCEPTION_NO_CONTROLLER = 'EXCEPTION_NO_CONTROLLER';

    /**
     * Const - No action exception; Controller exists, but action does not
     */
    const EXCEPTION_NO_ACTION = 'EXCEPTION_NO_ACTION';

    /**
     * Const - No route exception; no routing was possible
     */
    const EXCEPTION_NO_ROUTE = 'EXCEPTION_NO_ROUTE';

    /**
     * Const - Other Exception; exceptions thrown by application controllers
     */
    const EXCEPTION_OTHER = 'EXCEPTION_OTHER';


    /**
     * Flag; are we already inside the error handler loop?
     * @var bool
     */
    protected $_isInsideErrorHandlerLoop = false;

    /**
     * Exception count logged at first invocation of Plugin
     * @var int
     */
    protected $_exceptionCountAtFirstEncounter = 0;

    /**
     * Module to use for errors; defaults to default module in Dispatcher
     * @var string
     */
    protected $_errorModule;

    /**
     * Controller to use for errors; defaults to 'error'
     * @var string
     */
    protected $_errorController = 'error';

    /**
     * Action to use for errors; defaults to 'error'
     * @var string
     */
    protected $_errorAction = 'error';


    /**
     * Constructor
     *
     * Options may include:
     * - module
     * - Controller
     * - action
     *
     * @param  Array $options
     * @return void
     */
    public function __construct(Array $options = array())
    {
        $this->setErrorHandler($options);
    }

    /**
     * setErrorHandler() - setup the error handling options
     *
     * @param  array $options
     * @return RThink_Controller_Plugin_ErrorHandler
     */
    public function setErrorHandler(Array $options = array())
    {
        if (isset($options['module'])) {
            $this->setErrorHandlerModule($options['module']);
        }
        if (isset($options['controller'])) {
            $this->setErrorHandlerController($options['controller']);
        }
        if (isset($options['action'])) {
            $this->setErrorHandlerAction($options['action']);
        }
        return $this;
    }

    /**
     * Set the module name for the error handler
     *
     * @param  string $module
     * @return RThink_Controller_Plugin_ErrorHandler
     */
    public function setErrorHandlerModule($module)
    {
        $this->_errorModule = (string) $module;
        return $this;
    }

    /**
     * Retrieve the current error handler module
     *
     * @return string
     */
    public function getErrorHandlerModule()
    {
        if (null === $this->_errorModule) {
            $this->_errorModule = RThink_Controller_Front::getInstance()->getDispatcher()->getDefaultModule();
        }
        return $this->_errorModule;
    }

    /**
     * Set the Controller name for the error handler
     *
     * @param  string $controller
     * @return RThink_Controller_Plugin_ErrorHandler
     */
    public function setErrorHandlerController($controller)
    {
        $this->_errorController = (string) $controller;
        return $this;
    }

    /**
     * Retrieve the current error handler Controller
     *
     * @return string
     */
    public function getErrorHandlerController()
    {
        return $this->_errorController;
    }

    /**
     * Set the action name for the error handler
     *
     * @param  string $action
     * @return RThink_Controller_Plugin_ErrorHandler
     */
    public function setErrorHandlerAction($action)
    {
        $this->_errorAction = (string) $action;
        return $this;
    }

    /**
     * Retrieve the current error handler action
     *
     * @return string
     */
    public function getErrorHandlerAction()
    {
        return $this->_errorAction;
    }

    /**
     * Route shutdown hook -- Ccheck for Router exceptions
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function routeShutdown(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {
        $this->_handleError($request, $response);
    }

    /**
     * Pre dispatch hook -- check for exceptions and dispatch error handler if
     * necessary
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function preDispatch(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {
        $this->_handleError($request, $response);
    }
	
    /**
     * Post dispatch hook -- check for exceptions and dispatch error handler if
     * necessary
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function postDispatch(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {
        $this->_handleError($request, $response);
    }

    /**
     * Handle errors and exceptions
     *
     * If the 'noErrorHandler' front Controller flag has been set,
     * returns early.
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    protected function _handleError(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {
        $frontController = RThink_Controller_Front::getInstance();

        if ($frontController->getParam('noErrorHandler')) {
            return;
        }


        if ($this->_isInsideErrorHandlerLoop) {
            $exceptions = $response->getException();
            if (count($exceptions) > $this->_exceptionCountAtFirstEncounter) {
                // Exception thrown by error handler; tell the front Controller to throw it
                $frontController->throwExceptions(true);
                throw array_pop($exceptions);
            }
        }

        // check for an exception AND allow the error handler Controller the option to forward
        if (($response->isException()) && (!$this->_isInsideErrorHandlerLoop)) {
            $this->_isInsideErrorHandlerLoop = true;

            // Get exception information
            $error            = new ArrayObject(array(), ArrayObject::ARRAY_AS_PROPS);
            $exceptions       = $response->getException();
            $exception        = $exceptions[0];
            $error->exception = $exception;

            $exceptionType    = get_class($exception);
            $error->exception = $exception;

            switch ($exceptionType) {
                case 'RThink_Controller_Router_Exception':
                    if (404 == $exception->getCode()) {
                        $error->type = self::EXCEPTION_NO_ROUTE;
                    } else {
                        $error->type = self::EXCEPTION_OTHER;
                    }
                    break;
                case 'RThink_Controller_Dispatcher_Exception':
                    $error->type = self::EXCEPTION_NO_CONTROLLER;
                    break;
                case 'RThink_Controller_Action_Exception':
                    if (404 == $exception->getCode()) {
                        $error->type = self::EXCEPTION_NO_ACTION;
                    } else {
                        $error->type = self::EXCEPTION_OTHER;
                    }
                    break;
                default:
                    $error->type = self::EXCEPTION_OTHER;
                    break;
            }

            // get a count of the number of exceptions encountered
            $this->_exceptionCountAtFirstEncounter = count($exceptions);

            // Keep a copy of the original Request
            $error->request = clone $request;

            // Forward to the error handler
            $request->setParam('error_handler', $error)
                    ->setModuleName($this->getErrorHandlerModule())
                    ->setControllerName($this->getErrorHandlerController())
                    ->setActionName($this->getErrorHandlerAction())
                    ->setDispatched(false);
        }
    }
}
