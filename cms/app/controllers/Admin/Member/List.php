<?php
/**
 * 学员列表
 * Class Admin_Member_ListController
 */
class Admin_Member_ListController extends Admin_AbstractController
{

    public function indexAction()
    {
        //检查权限
        $this->verify(__METHOD__);

        $show['pagename'] = '学员列表';

        $grade = $this->getRequest()->getQuery('Grade');
        // $email = $this->getRequest()->getQuery('Email');
        $mobile = $this->getRequest()->getQuery('Mobile');
        $name = $this->getRequest()->getQuery('Name');
        $perpage = 20;

        $page = intval($this->getRequest()->getQuery('page'));
        $page = $page ? $page : 1;
        $data = $count_opt = array();
        $option = array(
            'condition' => '',
            'order' => 'Grade asc',
            'limit' => array('offset' => ($page - 1) * $perpage, 'count' => $perpage)
        );

        $conditionArr = $bindArr = array();
        if (!empty($grade)) {
            $conditionArr[] = "grade = ?";
            $bindArr[] = $grade;
        }
        if (!empty($mobile)) {
            $conditionArr[] = "mobile = ?";
            $bindArr[] = $mobile;
        }
        if (!empty($name)) {
            $conditionArr[] = "name like ?";
            $bindArr[] = "%$name%";
        }
        $option['condition'] = $count_opt['condition'] = implode(' and ', $conditionArr);
        $option['bind'] = $count_opt['bind'] = $bindArr;
        // print_r($option);exit;
        $data['memberList'] = Admin_MemberModel::instance()->fetchAll($option);
        $data['count'] = Admin_MemberModel::instance()->count($count_opt);
        $data['grade'] = RThink_Config::get('app.grade');
        $pagination = new Pagination();
        $data['pagination'] = $pagination->maxnum($data['count'], $perpage)->show('page_metronic');
        // $data['menu'] = Widget_Admin_MenuModel::headerMenu();
        $data['query'] = array(
            'Mobile' => $mobile,
            'Grade' => $grade,
            'Name' => $name,
        );
        // $subject = Admin_SubjectModel::instance()->fetchAll(array());
        // $subjectList = array();
        // foreach ($subject as $key => $value) {
        //     if(!isset($subjectList[$value['Grade']])){
        //         $subjectList[$value['Grade']] = array();
        //     }
        //     array_push($subjectList[$value['Grade']], $value);
        // }
        // $data['subjectList'] = $subjectList;
        // print_r($data);exit;
        $this->setInvokeArg('layout', 'admin1_layout');
        $this->render($data);
    }

}