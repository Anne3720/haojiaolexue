<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ClassModel');
        $this->load->model('CommonModel');
        $this->load->config('myconfig');
    }
    public function classList(){
        $where = array();
        $return_data = $this->ClassModel->getSubjectList();
        $grade = $this->config->item('grade');
        $subject = array();
        foreach ($return_data as $value) {
            $subject[$value['Grade']][] = $value;
        }
        $num = 20;
        $page = $this->input->get('page');
        $page = $page?$page:0;
        $offset = $page*$num;
        $classList = $this->ClassModel->getClassList($offset,$num,$where);
        $data['subject'] = $subject;
        $data['grade'] = $grade;
        $data['classList'] = $classList;
         //print_r($data);exit;
        //var_dump($data);exit;
        $this->load->view('class/classList',$data);
    }
    public function getSubjectListByGrade($grade)
    {
    	$data = $this->ClassModel->getSubjectListByGrade($grade);    	
        $this->load->view('Class/SubjectList.php',$data);
    }
    public function getClassListByGradeAndSubject($grade,$subject)
    {
    	$data = $this->ClassModel->getClassListByGradeAndSubject($grade,$subject);   	
        $this->load->view('Class/ClassList.php',$data);
    }
    public function getVideoByClassID($classid){
        $userInfo = json_decode($this->session->userdata('userInfo'));
        //未登录跳转
        if(!$userInfo){
        	redirect('/User/Login');
        }
        //登陆以后查看用户是否已购买该课程
        $MemberID = $userInfo['MemberID'];
        $classBought = $this->ClassModel->checkClassBought($MemberID,$classid);
        if($classBought){
    		$data = $this->ClassModel->getVideoByClassID($classid);
        }else{

        }
    }
    //获取用户已购买课程列表
    public function getMyClass(){
        $userInfo = json_decode($this->session->userdata('userInfo'));
        //未登录跳转
        if(!$userInfo){
        	redirect('/User/Login');
        }
        $MemberID = $userInfo['MemberID'];
        $data = $this->ClassModel->getMyClass($MemberID);
    }
}
 