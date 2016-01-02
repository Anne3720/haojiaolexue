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
 