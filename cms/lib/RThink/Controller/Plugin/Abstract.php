<?php
abstract class RThink_Controller_Plugin_Abstract
{

    /**
     * Called before Zend_Controller_Front begins evaluating the
     * Request against its routes.
     *
     * @param RThink_Controller_Request $request
     * @return void
     */
    public function routeStartup(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {}

    /**
     * Called after Zend_Controller_Router exits.
     *
     * Called after Zend_Controller_Front exits from the Router.
     *
     * @param  RThink_Controller_Request $request
     * @return void
     */
    public function routeShutdown(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {}

    /**
     * Called before Zend_Controller_Front enters its dispatch loop.
     *
     * @param  RThink_Controller_Request $request
     * @return void
     */
    public function dispatchLoopStartup(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {}

    /**
     * Called before an action is dispatched by Zend_Controller_Dispatcher.
     *
     * This callback allows for proxy or filter behavior.  By altering the
     * Request and resetting its dispatched flag (via
     * {@link RThink_Controller_Request::setDispatched() setDispatched(false)}),
     * the current action may be skipped.
     *
     * @param  RThink_Controller_Request $request
     * @return void
     */
    public function preDispatch(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {}

    /**
     * Called after an action is dispatched by Zend_Controller_Dispatcher.
     *
     * This callback allows for proxy or filter behavior. By altering the
     * Request and resetting its dispatched flag (via
     * {@link RThink_Controller_Request::setDispatched() setDispatched(false)}),
     * a new action may be specified for dispatching.
     *
     * @param  RThink_Controller_Request $request
     * @return void
     */
    public function postDispatch(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {}

    /**
     * Called before Zend_Controller_Front exits its dispatch loop.
     *
     * @return void
     */
    public function dispatchLoopShutdown(RThink_Controller_Response $response)
    {}
}
