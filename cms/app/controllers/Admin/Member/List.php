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
        $data['memberList'] = Admin_MemberModel::instance()->fetchAll($option);
        $data['count'] = Admin_MemberModel::instance()->count($count_opt);
        $data['grade'] = RThink_Config::get('app.grade');
        $pagination = new Pagination();
        $data['pagination'] = $pagination->maxnum($data['count'], $perpage)->show('page_metronic');
        $data['query'] = array(
            'Mobile' => $mobile,
            'Grade' => $grade,
            'Name' => $name,
        );
        $this->setInvokeArg('layout', 'admin1_layout');
        $this->render($data);
    }

}