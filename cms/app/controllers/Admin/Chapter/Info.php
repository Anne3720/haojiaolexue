<?php

/**
 *  添加科目
 * Class Admin_Chapter_InfoController
 */
class Admin_Chapter_InfoController extends Admin_AbstractController
{

    public function indexAction()
    {
        $this->verify(__METHOD__);
        $Grade = $this->getRequest()->getPost('Grade');
        $SubjectID = $this->getRequest()->getPost('SubjectID');
        $Title = $this->getRequest()->getPost('Title');
        $Chapter = $this->getRequest()->getPost('Chapter');
        $subject = RThink_Config::get('app.subject');
        $data = array(
            'Grade' => $Grade,
            'Title' => $Title,
            'Chapter' => $Chapter,
            'SubjectID' => $SubjectID,
            'CreateTime' => date('Y-m-d H:i:s'),
        );
        /* 写入账号 */
        Admin_ChapterModel::instance()->add($data);
        $this->sendMsg(1, "操作成功");
    }
}


