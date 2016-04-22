<?php

/**
 * 生成课程编号
 * Class Admin_Classes_CreateClassNoController
 */
class Admin_Classes_CreateClassNoController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
        $this->verify(__METHOD__);
        $Grade = $this->getRequest()->getParam('Grade');
        $SubjectID = $this->getRequest()->getParam('SubjectID');
        $Chapter = $this->getRequest()->getParam('Chapter');
        if(empty($Grade)||empty($SubjectID)||empty($Chapter)){
            $this->sendMsg(1, '请将课程信息填写完整');
        }
        $option = array(
            'condition' => 'Grade = ? and SubjectID = ? and Chapter = ?',
            'bind' => array($Grade,$SubjectID,$Chapter),
            'order' => 'No desc',
            'limit' => ''
        );
        $rs = Admin_ClassesModel::instance()->getMaxNo($option);
        $data['No'] = $rs[0]['maxNo']?$rs[0]['maxNo']+1:1;
        $this->sendMsg(0, '成功', $data);
    }

}