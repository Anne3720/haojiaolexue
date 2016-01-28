<?php
/**
 * 推荐课程列表
 * Class Admin_Recommend_ListController
 */
class Admin_Recommend_ListController extends Admin_AbstractController
{

    public function indexAction()
    {
        //检查权限
        $admin = $this->verify(__METHOD__);
        $show['pagename'] = '推荐课程列表';

        $MemberID = $this->getRequest()->getQuery('MemberID',0);
        $SubjectID = $this->getRequest()->getQuery('SubjectID');
        $perpage = 20;

        $page = intval($this->getRequest()->getQuery('page'));
        $page = $page ? $page : 1;
        $data = $count_opt = array();
        $option = array(
            'condition' => 'A.MemberID = ?',
            'bind' => array($MemberID),
            'order' => 'RecommendID desc',
            'limit' => array('offset' => ($page - 1) * $perpage, 'count' => $perpage)
        );
        if(!empty($SubjectID)){
            $option['condition'].=' and B.SubjectID = ?';
            $option['bind'][] = $SubjectID;
        }
        $data['RecommendList'] = Admin_RecommendModel::instance()->getRecommendClassList($option);
        $data['count'] = Admin_RecommendModel::instance()->count($count_opt);
        $data['grade'] = RThink_Config::get('app.grade');

        $member_option = array(
            'condition' => 'MemberID = ?',
            'bind' => array($MemberID),
        );
        $MemberInfo = Admin_MemberModel::instance()->fetchAll($member_option);
        $data['MemberInfo'] = $MemberInfo[0];

        $TeacherList = Admin_AdminModel::instance()->fetchAll(array());
        $TeacherList_tmp = array();
        foreach ($TeacherList as $key => $value) {
            $TeacherList_tmp[$value['id']] = $value;
        }
        $data['TeacherList'] = $TeacherList_tmp;

        $grade = $MemberInfo[0]['Grade'];
        $member_option = array(
            'condition' => 'Grade = ?',
            'bind' => array($grade),
        );
        $data['SubjectList'] = Admin_SubjectModel::instance()->fetchAll($member_option);

        $pagination = new Pagination();
        $data['pagination'] = $pagination->maxnum($data['count'], $perpage)->show('page_metronic');
        $data['query'] = array(
            'MemberID'=>$MemberID,
            'SubjectID'=>$SubjectID,
        );
        $this->setInvokeArg('layout', 'admin1_layout');
        $this->render($data);
    }

}