<?php

class Test extends RThink_Controller_Plugin_Abstract
{

    public function routeStartup(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {
        echo '<p>在路由之前触发</p>';
    }

    public function routeShutdown(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {
        echo '<p>路由结束之后触发</p>';
    }

    public function dispatchLoopStartup(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {
        echo '<p>分发循环开始之前被触发</p>';
    }

    public function preDispatch(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {
        echo '<p>分发之前触发</p>';
    }

    public function postDispatch(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {
        echo '<p>分发之前触发</p>';
    }

    public function dispatchLoopShutdown(RThink_Controller_Response $response)
    {
        echo '<p>分发循环结束之后触发</p>';
    }

}