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
        $maxNo = Admin_ClassesModel::instance()->getMaxNo($option);
        $No = $maxNo?($maxNo+1):1;
        $option1 = array(
            'condition' => 'SubjectID = ? ',
            'bind' => array($SubjectID),
            'limit' => ''
        );
        $SubjectType = Admin_SubjectModel::instance()->getSubjectType($option1);
        $data['ClassNo'] = sprintf("%d%02d%02d%02d",$SubjectType,$Grade,$Chapter,$No);
        $data['No'] = $No;
        $this->sendMsg(0, '成功', $data);
    }

}