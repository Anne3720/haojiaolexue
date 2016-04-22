<?php
/**
 * 章节列表
 * Class Admin_Chapter_ListController
 */
class Admin_Chapter_ListController extends Admin_AbstractController
{

    public function indexAction()
    {
        //检查权限
        $this->verify(__METHOD__);

        $show['pagename'] = '章节列表';

        $grade = $this->getRequest()->getQuery('Grade', '');
        $subjectID = $this->getRequest()->getQuery('SubjectID', '');

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
            $conditionArr[] = "Grade = ?";
            $bindArr[] = $grade;
        }
        if (!empty($subjectID)) {
            $conditionArr[] = "SubjectID = ?";
            $bindArr[] = $subjectID;
        }
        $option['condition'] = $count_opt['condition'] = implode(' and ', $conditionArr);
        $option['bind'] = $count_opt['bind'] = $bindArr;
        $data['ChapterList'] = Admin_ChapterModel::instance()->fetchAll($option);
        
        $subject = Admin_SubjectModel::instance()->fetchAll(array());
        $subjectList = array();
        foreach ($subject as $key => $value) {
            if(!isset($subjectList[$value['Grade']])){
                $subjectList[$value['Grade']] = array();
            }
            array_push($subjectList[$value['Grade']], $value);
        }
        $data['subjectList'] = $subjectList;
        $data['count'] = Admin_ChapterModel::instance()->count($count_opt);
        $data['grade'] = RThink_Config::get('app.grade');
        $pagination = new Pagination();
        $data['pagination'] = $pagination->maxnum($data['count'], $perpage)->show('page_metronic');
        $data['menu'] = Widget_Admin_MenuModel::headerMenu();
        $this->setInvokeArg('layout', 'admin1_layout');
        $this->render($data);
    }

}