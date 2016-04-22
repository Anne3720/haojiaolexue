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
        $SubjectType = $this->getRequest()->getPost('SubjectType');
        $subject = RThink_Config::get('app.subject');
        $Title = $subject[$SubjectType];
        if (empty($Title)) {
            $this->sendMsg(-1, '科目添加异常');
        }

        $data = array(
            'Grade' => $Grade,
            'Title' => $Title,
            'SubjectType' => $SubjectType,
            'CreateTime' => date('Y-m-d H:i:s'),
        );
        /* 写入账号 */
        Admin_SubjectModel::instance()->add($data);
        $this->sendMsg(1, "操作成功");
    }
}


