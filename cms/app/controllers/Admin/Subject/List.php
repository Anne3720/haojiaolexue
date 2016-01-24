<?php
/**
 * 科目列表
 * Class Admin_Subject_ListController
 */
class Admin_Subject_ListController extends Admin_AbstractController
{

    public function indexAction()
    {
        //检查权限
        $this->verify(__METHOD__);

        $show['pagename'] = '科目列表';

        $grade = $this->getRequest()->getQuery('grade', '');

        $perpage = 20;

        $page = intval($this->getRequest()->getQuery('page'));
        $page = $page ? $page : 1;
        $data = $count_opt = array();
        $option = array(
            'condition' => '',
            'order' => 'SubjectID asc',
            'limit' => array('offset' => ($page - 1) * $perpage, 'count' => $perpage)
        );

        $data['count'] = Admin_AdminModel::instance()->count($count_opt);
        if (!empty($grade)) {
            $option['condition'] .= "grade = ?";
            $option['bind'] = array($grade);
            $count_opt = array('condition' => "grade = ?", 'bind' => array($grade));
        }

        $data['subjectList'] = Admin_SubjectModel::instance()->fetchAll($option);
        $data['count'] = Admin_SubjectModel::instance()->count($count_opt);
        $data['grade'] = RThink_Config::get('app.grade');
        $pagination = new Pagination();
        $data['pagination'] = $pagination->maxnum($data['count'], $perpage)->show('page_metronic');
        $data['menu'] = Widget_Admin_MenuModel::headerMenu();
        $this->setInvokeArg('layout', 'admin1_layout');
        $this->render($data);
    }

}