<?php

class Api_Sys_UpdateController extends RThink_Controller_Action
{
	public function indexAction()
	{
//        $this->getFrontController()->getResponse()->setHttpResponseCode(404);
        $this->getResponse()->setHeader('Content-Type', 'text/html;charset=utf8');

      	echo "API路径：controllers -> Api -> Sys -> update";
	}
}