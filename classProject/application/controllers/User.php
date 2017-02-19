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
    public function information(){
        $this->load->view('User/Information');
    }
    public function reg(){
        $this->load->view('User/Reg');
    }
    public function doReg(){
        $data['Mobile'] = $this->input->post('Mobile');
        $data['Email'] = $this->input->post('Email');
        $data['Name'] = $this->input->post('Name');
        $data['Gender'] = $this->input->post('Gender');
        $data['Grade'] = $this->input->post('Grade');
        $data['School'] = $this->input->post('School');
        $Password = $this->input->post('PassWord');
        $data['Password'] = md5($Password.md5($Password));
        $data['Province'] = $this->input->post('Province');
        $data['City'] = $this->input->post('City');
        $data['District'] = $this->input->post('District');
        $UserExists = $this->UserModel->checkUserExists($data['Mobile'],$data['Email']);
        $data['CreateTime'] = date('Y-m-d H:i:s');
        if($UserExists){
            $status = $this->config->item('STATUS_REG_USEREXISTS');
            $msg = $this->config->item('MSG_REG_USEREXISTS');
            $this->CommonModel->sendMsg($status,array(),$msg);
        }
        $data = $this->UserModel->addUser($data);
        $emailConfig = $this->config->item('email');
        $validate = md5($Mobile.'haojiaolexue');
        $content = "<p>欢迎加入好教乐学，祝您开启一段愉快的学习旅程！请在半小时之内点击以下链接激活<a>http://".$_SERVER['HTTP_HOST']."/user/doactivate/{$validate}</a></p>";
        $this->CommonModel->sendSimpleEmail($emailConfig['smtp_user'],$Email,'好教乐学账号激活',$content,$emailConfig);
        $this->cache->memcached->save("{$validate}", "{$Mobile}", 1800);
        $status = $this->config->item('STATUS_REG_SUCCESS');
        $msg = $this->config->item('MSG_REG_SUCCESS');
        $this->CommonModel->sendMsg($status,array(),$msg);
        //var_dump($msg);
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
    public function doActivate($validate){
        $mobile = $this->cache->memcached->get("{$validate}");
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
        redirect('/user/login','refresh');//这是退出到登陆页面
    }

    public function forgetPassword(){
        $this->load->view('User/ForgetPassword');
    }
    public function findPassword(){
        $emailConfig = $this->config->item('email');
        $email = $this->input->post('email');
        $validate = md5(trim($email).'haojiaolexue');
        $content = "<p>请点击以下链接修改密码<a>http://".$_SERVER['HTTP_HOST']."/user/resetpassword/{$validate}</a></p>";
        $this->CommonModel->sendSimpleEmail($emailConfig['smtp_user'],$Email,'好教乐学密码重置',$content,$emailConfig);
        $this->cache->memcached->save("{$validate}", "{$email}", 1800);
        $this->load->view('User/FindPassword');
    }
    public function resetPassword(){
        $this->load->view('User/ResetPassword');
    }
    public function doResetPassword(){
        $password = $this->input->post("password");
        $password1 = $this->input->post("password1");
        $validate = $this->input->post("validate");
        $email = $this->cache->memcached->get("{$validate}");
        if(!$email){
            $this->sendMsg(-1,array(),"重置密码失败");
        }
        if($password!==$password1){
            $this->sendMsg(-1,array(),"两次输入密码不一致，请重新输入");
        }else{
            $password = md5($password.md5($password));
            $this->UserModel->resetPassword($email,$password);
            $this->sendMsg(0,array(),"密码修改成功");
        }
    }

    public function userInfo(){
        $userInfo = $this->UserModel->checkLogin();
        if(empty($userInfo)){
            redirect('/user/login');
        }else{
            $this->load->view('/user/userinfo');
        }
    }

    public function updateUserInfo(){
        $userInfo = $this->UserModel->checkLogin();
        $data['Mobile'] = $this->input->post('Mobile');
        $data['Email'] = $this->input->post('Email');
        $data['Name'] = $this->input->post('Name');
        $data['Gender'] = $this->input->post('Gender');
        $data['Grade'] = $this->input->post('Grade');
        $data['School'] = $this->input->post('School');
        $PassWord = $this->input->post('PassWord');
        if(!empty($PassWord)){
            $data['Password'] = $this->input->post('Password');
        }
        $data['Province'] = $this->input->post('Province');
        $data['City'] = $this->input->post('City');
        $data['District'] = $this->input->post('District');
        $where['MemberID'] = $userInfo['MemberID'];
        $this->UserModel->updateUserInfo($data,$where);
        $this->sendMsg(0,array(),'修改成功');
    }
}
