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
        $this->setInvokeArg('layout', 'admin1_layout');
        $this->render($data);
    }

}