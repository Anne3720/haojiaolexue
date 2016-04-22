<?php
/**
 * 编辑章节
 * Class Admin_Chapter_EditController
 */
class Admin_Chapter_EditController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
       $this->verify(__METHOD__);
        //@todo  $this->verify(__METHOD__);

        // $id = $this->getRequest()->getParam('id');
        $data = array();
        $data['grade'] = RThink_Config::get('app.grade');
        $data['subject'] = RThink_Config::get('app.subject');
        $data['pagename'] = '菜单添加';
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