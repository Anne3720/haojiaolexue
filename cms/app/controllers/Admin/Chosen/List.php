<?php
/**
 * 选择课程列表
 * Class Admin_Chosen_ListController
 */
class Admin_Chosen_ListController extends Admin_AbstractController
{

    public function indexAction()
    {
        //检查权限
        $admin = $this->verify(__METHOD__);
        $show['pagename'] = '选择课程列表';

        $MemberID = $this->getRequest()->getParam('MemberID',0);
        $Grade = $this->getRequest()->getParam('Grade',0);
        $SubjectID = $this->getRequest()->getParam('SubjectID',0);
        $perpage = 20;

        $page = intval($this->getRequest()->getParam('page'));
        $page = $page ? $page : 1;
        $data = $count_opt = array();
        //个人信息
        $member_option = array(
            'condition' => 'MemberID = ?',
            'bind' => array($MemberID),
        );
        $MemberInfo = Admin_MemberModel::instance()->fetchAll($member_option);
        $data['MemberInfo'] = $MemberInfo[0];
        $Grade = empty($Grade)?$MemberInfo[0]['Grade']:$Grade;
        //所选课程列表
        $option = array(
            // 'condition' => 'A.MemberID = ? and B.Grade = ?',
            // 'bind' => array($MemberID,$Grade),
            'order' => 'ChosenID desc,B.ClassNo asc',
            'limit' => array('offset' => ($page - 1) * $perpage, 'count' => $perpage)
        );
        if(!empty($SubjectID)){
            $option['condition'][]='B.SubjectID = ?';
            $option['bind'][] = $SubjectID;
        }        
        if(!empty($Grade)){
            $option['condition'][]='B.Grade = ?';
            $option['bind'][] = $Grade;
        }
        if(!empty($MemberID)){
            $option['condition'][]='A.MemberID = ?';
            $option['bind'][] = $MemberID;
        }
        $option['condition'] = implode(' and ', $option['condition']);
        $count_opt['condition'] = $option['condition'];
        $count_opt['bind'] = $option['bind'];
        $data['ChosenList'] = Admin_ChosenModel::instance()->getChosenClassList($option);
        $count = Admin_ChosenModel::instance()->getChosenCount($count_opt);
        $data['count'] = $count[0]['count'];
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
        $pagination = new Pagination();
        $data['pagination'] = $pagination->maxnum($data['count'], $perpage)->show('page_metronic');
        $data['query'] = array(
            'MemberID'=>$MemberID,
            'SubjectID'=>$SubjectID,
            'Grade'=> $Grade,
        );
        $this->setInvokeArg('layout', 'admin1_layout');
        $this->render($data);
    }

}