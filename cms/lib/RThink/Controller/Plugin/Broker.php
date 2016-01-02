<?php
require_once 'RThink/Controller/Plugin/Abstract.php';

/**
 * Class RThink_Controller_Plugin_Broker
 */
class RThink_Controller_Plugin_Broker extends RThink_Controller_Plugin_Abstract
{

    /**
     * Array of instance of objects extending RThink_Controller_Plugin_Abstract
     *
     * @var array
     */
    protected $_plugins = array();


    /**
     * Register a Plugin.
     *
     * @param  RThink_Controller_Plugin_Abstract $Plugin
     * @param  int $stackIndex
     * @return ControllerBroker
     */
    public function registerPlugin(array $plugins)
    {

        foreach ($plugins as $plugin) {
            if (!$plugin instanceof RThink_Controller_Plugin_Abstract) {
                throw new RThink_Exception('插件{'.get_class($plugin).'}不是RThink_Controller_Plugin_Abstract的子类！');
            }

            $this->_plugins[] = $plugin;
        }

    }



    /**
     * Called before RThink_Controller_Front begins evaluating the
     * Request against its routes.
     *
     * @param RThink_Controller_Request $request
     * @return void
     */
    public function routeStartup(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {
        foreach ($this->_plugins as $plugin) {
            try {
                $plugin->routeStartup($request, $response);
            } catch (Exception $e) {
                if (RThink_Controller_Front::getInstance()->throwExceptions()) {
                    throw new RThink_Exception($e->getMessage() . $e->getTraceAsString(), $e->getCode(), $e);
                } else {
                    $response->setException($e);
                }
            }
        }
    }


    /**
     * Called before RThink_Controller_Front exits its iterations over
     * the route set.
     *
     * @param  RThink_Controller_Request $request
     * @return void
     */
    public function routeShutdown(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {
        foreach ($this->_plugins as $plugin) {
            try {
                $plugin->routeShutdown($request, $response);
            } catch (Exception $e) {
                if (RThink_Controller_Front::getInstance()->throwExceptions()) {
                    throw new RThink_Exception($e->getMessage() . $e->getTraceAsString(), $e->getCode(), $e);
                } else {
                    $response->setException($e);
                }
            }
        }
    }


    /**
     * Called before RThink_Controller_Front enters its dispatch loop.
     *
     * During the dispatch loop, RThink_Controller_Front keeps a
     * RThink_Controller_Request object, and uses
     * Zend_Controller_Dispatcher to dispatch the
     * RThink_Controller_Request object to controllers/actions.
     *
     * @param  RThink_Controller_Request $request
     * @return void
     */
    public function dispatchLoopStartup(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {
        foreach ($this->_plugins as $plugin) {
            try {
                $plugin->dispatchLoopStartup($request, $response);
            } catch (Exception $e) {
                if (RThink_Controller_Front::getInstance()->throwExceptions()) {
                    throw new RThink_Exception($e->getMessage() . $e->getTraceAsString(), $e->getCode(), $e);
                } else {
                    $response->setException($e);
                }
            }
        }
    }


    /**
     * Called before an action is dispatched by Zend_Controller_Dispatcher.
     *
     * @param  RThink_Controller_Request $request
     * @return void
     */
    public function preDispatch(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {
        foreach ($this->_plugins as $plugin) {
            try {
                $plugin->preDispatch($request, $response);
            } catch (Exception $e) {
                if (RThink_Controller_Front::getInstance()->throwExceptions()) {
                    throw new RThink_Exception($e->getMessage() . $e->getTraceAsString(), $e->getCode(), $e);
                } else {
                    $response->setException($e);
					// skip rendering of normal dispatch give the error handler a try
					$request->setDispatched(false);
                }
            }
        }
    }


    /**
     * Called after an action is dispatched by Zend_Controller_Dispatcher.
     *
     * @param  RThink_Controller_Request $request
     * @return void
     */
    public function postDispatch(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {
        foreach ($this->_plugins as $plugin) {
            try {
                $plugin->postDispatch($request, $response);
            } catch (Exception $e) {
                if (RThink_Controller_Front::getInstance()->throwExceptions()) {
                    throw new RThink_Exception($e->getMessage() . $e->getTraceAsString(), $e->getCode(), $e);
                } else {
                    $response->setException($e);
                }
            }
        }
    }


    /**
     * Called before RThink_Controller_Front exits its dispatch loop.
     *
     * @param  RThink_Controller_Request $request
     * @return void
     */
    public function dispatchLoopShutdown(RThink_Controller_Response $response)
    {
       foreach ($this->_plugins as $plugin) {
           try {
                $plugin->dispatchLoopShutdown($response);
            } catch (Exception $e) {
                if (RThink_Controller_Front::getInstance()->throwExceptions()) {
                    throw new RThink_Exception($e->getMessage() . $e->getTraceAsString(), $e->getCode(), $e);
                } else {
                    $response->setException($e);
                }
            }
       }
    }
}
