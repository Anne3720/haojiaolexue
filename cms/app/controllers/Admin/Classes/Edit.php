<?php
/**
 * 编辑课程
 * Class Admin_Classes_EditController
 */
class Admin_Classes_EditController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
        $this->verify(__METHOD__);
        $classid = $this->getRequest()->getParam('ClassID');
        $data = array();

        if (empty($classid)) {
            $data['pagename'] = '课程添加';
            $data['info'] = array();
        } else {
            $data['pagename'] = '课程编辑';
            $data['info'] = Admin_ClassesModel::instance()->fetchRow(array('condition' => 'classid = ?', 'bind' => array($classid)));
        }
        $data['grade'] = RThink_Config::get('app.grade');
        $subject = Admin_SubjectModel::instance()->fetchAll(array());
        $subjectList = array();
        foreach ($subject as $key => $value) {
            if(!isset($subjectList[$value['Grade']])){
                $subjectList[$value['Grade']] = array();
            }
            array_push($subjectList[$value['Grade']], $value);
        }
        $data['subjectList'] = $subjectList;
        $this->setInvokeArg('layout', 'admin1_layout');
        $this->render($data);
    }

}