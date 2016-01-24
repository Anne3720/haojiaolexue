<?php

/**
 *  添加科目
 * Class Admin_Subject_InfoController
 */
class Admin_Subject_InfoController extends Admin_AbstractController
{

    public function indexAction()
    {
        $this->verify(__METHOD__);

        $Grade = $this->getRequest()->getPost('Grade');
        $Title = $this->getRequest()->getPost('Title');
        if (empty($Title)) {
            $this->sendMsg(-1, '科目名不能为空');
        }

        $data = array(
            'Grade' => $Grade,
            'Title' => $Title,
        );
        /* 写入账号 */
        Admin_SubjectModel::instance()->add($data);
        $this->sendMsg(1, "操作成功");
    }
}


