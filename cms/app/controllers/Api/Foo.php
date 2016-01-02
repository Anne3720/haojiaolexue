<?php

class Api_FooController extends RThink_Controller_Action
{
	public function indexAction()
	{
        $this->getResponse()->setHeader('Content-Type', 'text/html;charset=utf8');

      	echo "API路径：controllers -> Api -> foo";
	}

    public function outputAction()
    {
        $data = array('name' => 'php');

        $this->getResponse()->setHeader('Content-Type', 'application/json;charset=utf-8');

        echo json_encode($data);
    }
}