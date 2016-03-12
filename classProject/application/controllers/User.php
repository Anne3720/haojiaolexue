<?php
class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->model('CommonModel');
        $this->load->config('myconfig');
        $this->load->helper('url');
    }
    public function reg(){
        $this->load->view('User/Reg');
    }
    public function doReg(){
        $Mobile = $this->input->post('Mobile');
        $Email = $this->input->post('Email');
        $Name = $this->input->post('Name');
        $Gender = $this->input->post('Gender');
        $Grade = $this->input->post('Grade');
        $School = $this->input->post('School');
        $Password = $this->input->post('PassWord');
        $UserExists = $this->UserModel->checkUserExists($Mobile,$Email);
        $CreateTime = date('Y-m-d H:i:s');
        if($UserExists){
            $status = $this->config->item('STATUS_REG_USEREXISTS');
            $msg = $this->config->item('MSG_REG_USEREXISTS');
            $this->CommonModel->sendMsg($status,array(),$msg);
        }
        $data = $this->UserModel->addUser($Mobile,$Email,$Name,$Gender,$Grade,$School,md5($Password.md5($Password)),$CreateTime);
        $emailConfig = $this->config->item('email');
        $validate = md5($Mobile.'haojiaolexue');
        $content = "<p>欢迎加入好教乐学，祝您开启一段愉快的学习旅程！请在半小时之内点击以下链接激活<a>http://".$_SERVER['HTTP_HOST']."/User/doActivate/{$Mobile}/{$validate}</a></p>";
        $this->CommonModel->sendSimpleEmail($emailConfig['smtp_user'],$Email,'test',$content,$emailConfig);
        $status = $this->config->item('STATUS_REG_SUCCESS');
        $msg = $this->config->item('MSG_REG_SUCCESS');
        $this->CommonModel->sendMsg($status,array(),$msg);
        var_dump($status);
    }
    public function login(){
        $this->load->view('User/Login');
    }
    public function doLogin(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $password = md5($password.md5($password));
        $isEmail = $this->UserModel->isEmail($username);
        $isMobile = $this->UserModel->isMobile($username);
        if($isEmail){
            $info = $this->UserModel->loginByEmail($username,$password);
        }elseif($isMobile){
            $info = $this->UserModel->loginByMobile($username,$password);
        }else{
            $info = $this->UserModel->loginByName($username,$password);
        }
        $return = array();
        if(!$info){
            $status = $this->config->item('STATUS_LOGIN_ERROR');
            $msg = $this->config->item('MSG_LOGIN_ERROR');
        }elseif($info['Activated']==0){
            $status = $this->config->item('STATUS_LOGIN_UNACTIVATED');
            $msg = $this->config->item('MSG_LOGIN_UNACTIVATED');
        }else{
            $status = $this->config->item('STATUS_LOGIN_SUCCESS');
            $msg = $this->config->item('MSG_LOGIN_SUCCESS');
            $this->session->set_userdata('userInfo',json_encode($info));
        }
        $this->CommonModel->sendMsg($status,array(),$msg);
        
    }
    public function doActivate($mobile,$validate){
        if(md5($mobile.'haojiaolexue')!=$validate){
            $status = $this->config->item('STATUS_ACTIVATED_FAIL');
            $msg = $this->config->item('MSG_ACTIVATED_FAIL');        
            $this->CommonModel->sendMsg($status,array(),$msg);
        }
        $this->UserModel->updateActivated($mobile);
        $status = $this->config->item('STATUS_ACTIVATED_SUCCESS');
        $msg = $this->config->item('MSG_ACTIVATED_SUCCESS');        
        $this->CommonModel->sendMsg($status,array(),$msg);
    }
    public function doLogout(){
        $this->session->sess_destroy();//注销所有session变量
        redirect('/User/login','refresh');//这是退出到登陆页面
    }
}
