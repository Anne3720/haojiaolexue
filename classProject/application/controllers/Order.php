<?php
class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ClassModel');
        $this->load->model('UserModel');
        $this->load->model('CommonModel');
        $this->load->config('myconfig');
        $this->load->helper('url');
    }

    //创建订单
    public function createOrder($classID){
        $userInfo = $this->UserModel->checkLogin();
        //未登录跳转
        if(empty($userInfo)){
            redirect('/User/Login');
        }
        //登陆以后查看用户是否已购买该课程
        $MemberID = $userInfo['MemberID'];
        $classInfo = $this->ClassModel->getVideoByClassID($classID);
        // $OrderNo
    }
}
