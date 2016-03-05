<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ClassModel');
        $this->load->model('CommonModel');
        $this->load->config('myconfig');
        $this->load->library('pagination');
        $this->load->helper('url');
    }
    public function classList(){
        $return_data = $this->ClassModel->getSubjectList();
        $grade = $this->config->item('grade');
        $subject = array();
        foreach ($return_data as $value) {
            $subject[$value['Grade']][] = $value;
        }
        $num =8;
        $page = $this->uri->segment(3);
        $page = $page?$page:1;
        $offset = $num*($page-1);
        $where = array();
        $inputGrade = $this->input->get('grade');
        $inputSubject = $this->input->get('subject');
        if(!empty($inputGrade)){
            $where['Grade'] = $inputGrade;
        }
        if(!empty($inputSubject)){
            $where['SubjectID'] = $inputSubject;
        }
        $classList = $this->ClassModel->getClassList($offset,$num,$where);
        $data['subject'] = $subject;
        $data['grade'] = $grade;
        $data['classList'] = $classList;
        //分页
        $config['base_url'] = '/Classes/classList';
        $config['total_rows'] = $this->ClassModel->getClassTotal($where);
        $config['per_page'] = $num;
        $config['now_index'] = $page;  
        $config['first_link'] = '首页';
        $config['last_link'] = '尾页';
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = true;
        $config['reuse_query_string'] = true; 
        $this->pagination->initialize($config);
            //传参数给VIEW
        $data['page_links'] = $this->pagination->create_links();
        // print_r($data['classList']);exit;
        $this->load->view('class/classList',$data);
        //var_dump($classList);exit;
        //print_r($data);exit;
        //var_dump($data);
    }
    //根据课程id获取对应视频地址
    public function video($classid){
        $userInfo = $this->session->userdata('userInfo');
        //未登录跳转
        if(!$userInfo){
        	redirect('/User/Login');
        }
        $userInfo = json_decode($userInfo,true);
        //登陆以后查看用户是否已购买该课程
        $MemberID = $userInfo['MemberID'];
        $classBought = $this->ClassModel->checkClassBought($MemberID,$classid);
        if($classBought){
    		$data = $this->ClassModel->getVideoByClassID($classid);
            $this->load->view('/class/vedioPlay',$data);

        }else{
            $this->load->view('/class/unPay');
        }
        // print_r($data);
    }
    //获取用户已购买课程列表
    public function myClass(){
        $userInfo = json_decode($this->session->userdata('userInfo'));
        //未登录跳转
        if(!$userInfo){
        	redirect('/User/Login');
        }
        $MemberID = $userInfo['MemberID'];
        $data = $this->ClassModel->getMyClass($MemberID);
        //var_dump($data);
    }
}
 