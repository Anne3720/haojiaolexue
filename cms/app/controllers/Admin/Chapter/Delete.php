<?php

/**
 * 删除科目
 * Class Admin_Chapter_DeleteController
 */
class Admin_Chapter_DeleteController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
        $this->verify(__METHOD__);
        $ChapterID = $this->getRequest()->getParam('ChapterID');
        Admin_ChapterModel::instance()->delete(array('ChapterID' => $ChapterID));

        $this->sendMsg(1, '删除成功');
    }

}