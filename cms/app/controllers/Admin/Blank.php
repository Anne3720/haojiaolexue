<?php

/**
 * index 控制器
 *
 * Class BlankController
 */
class Admin_BlankController extends Admin_AbstractController
{

    public function indexAction()
    {
        $data = array();

        $this->render($data);
    }

}