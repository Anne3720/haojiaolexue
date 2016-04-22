<?php
/**
 * 课程列表
 * Class Admin_Classes_ListController
 */
class Admin_Classes_ListController extends Admin_AbstractController
{

    public function indexAction()
    {
        //检查权限
        $this->verify(__METHOD__);

        $show['pagename'] = '课程列表';

        $grade = $this->getRequest()->getQuery('Grade');
        $subject = $this->getRequest()->getQuery('SubjectID');
        $chapter = $this->getRequest()->getQuery('Chapter');
        $classno = $this->getRequest()->getQuery('ClassNo');
        $memberID = $this->getRequest()->getQuery('MemberID');
        $perpage = 20;

        $page = intval($this->getRequest()->getQuery('page'));
        $page = $page ? $page : 1;
        $data = $count_opt = array();
        $option = array(
            'condition' => '',
            'order' => 'ClassNo asc,Grade asc',
            'limit' => array('offset' => ($page - 1) * $perpage, 'count' => $perpage)
        );

        $data['count'] = Admin_AdminModel::instance()->count($count_opt);
        $conditionArr = $bindArr = array();
        if (!empty($grade)) {
            $conditionArr[] = "grade = ?";
            $bindArr[] = $grade;
        }
        if (!empty($subject)) {
            $conditionArr[] = "subjectid = ?";
            $bindArr[] = $subject;
        }
        if (!empty($classno)) {
            $conditionArr[] = "classno = ?";
            $bindArr[] = $classno;
        }
        if (!empty($chapter)) {
            $conditionArr[] = "chapter = ?";
            $bindArr[] = $chapter;
        }
        $option['condition'] = $count_opt['condition'] = implode(' and ', $conditionArr);
        $option['bind'] = $count_opt['bind'] = $bindArr;
        // print_r($option);exit;
        $data['classList'] = Admin_ClassesModel::instance()->fetchAll($option);
        $data['count'] = Admin_ClassesModel::instance()->count($count_opt);
        $data['grade'] = RThink_Config::get('app.grade');
        $pagination = new Pagination();
        $data['pagination'] = $pagination->maxnum($data['count'], $perpage)->show('page_metronic');
        $data['menu'] = Widget_Admin_MenuModel::headerMenu();
        $data['query'] = array(
            'ClassNo' => $classno,
            'Grade' => $grade,
            'SubjectID' => $subject,
            'Chapter' => $chapter,
            'MemberID' => $memberID,
        );
        $subject = Admin_SubjectModel::instance()->fetchAll(array());
        $subjectList = array();
        foreach ($subject as $key => $value) {
            if(!isset($subjectList[$value['Grade']])){
                $subjectList[$value['Grade']] = array();
            }
            array_push($subjectList[$value['Grade']], $value);
        }
        $data['subjectList'] = $subjectList;
        $recommendClassIds = array();
        if(!empty($memberID)){
            $recommend_option = array(
            'fields' => 'ClassID',
            'condition' => 'MemberID = ?',
            'bind' => array($memberID),
            'order' => 'ClassID desc',
            'limit' => '',
            );
            $recommendClasses = Admin_RecommendModel::instance()->fetchAll($recommend_option);
            foreach ($recommendClasses as $key => $value) {
                $recommendClassIds[] = $value['ClassID'];
            }
        }
        $data['recommendClassIds'] = $recommendClassIds;
        $this->setInvokeArg('layout', 'admin1_layout');
        $this->render($data);
    }

}