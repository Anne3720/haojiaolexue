<?php
/**
* 用户类
*/
class UserModel extends CI_Model {
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }    
    /*
    *邮箱校验
    * @param $str string 邮箱账号
    *return boolean
    */
    function isEmail($str){ 
        $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i"; 
        return preg_match($pattern, $str); 
    } 
    /*
	*手机号码校验
	* @param $str string 手机号
	*return boolean
	*/
	function isMobile($str){ 
		$pattern = "/^1[358][0-9]{9}$/i"; 
		return preg_match($pattern, $str); 
	} 
	/*
	*邮箱登陆
	* @param $email    string 邮箱账号
	* @param $password string 密码
	* @return array
	*/
	function loginByEmail($email,$password){
		$this->db->where('Email',$email);
		$this->db->where('Password',$password);
		$query = $this->db->get('Tbl_Member');
        $data = $query->result_array();
		return isset($data[0])?$data[0]:array();
	}
    /*
    *邮箱登陆
    * @param $mobile   string 手机号
    * @param $password string 密码
    * @return array
    */
    function loginByMobile($mobile,$password){
        $this->db->where('Mobile',$mobile);
        $this->db->where('Password',$password);
        $query = $this->db->get('Tbl_Member');
        $data = $query->result_array();
        return isset($data[0])?$data[0]:array();
    }
	/*
	*用户名登录
	* @param $name     string 用户名
	* @param $password string 密码
	* @return array
	*/
	function loginByName($name,$password){
		$this->db->where('Name',$name);
		$this->db->where('Password',$password);
		$query = $this->db->get('Tbl_Member');
        $data = $query->result_array();
		return isset($data[0])?$data[0]:array();
	}
    /*
    *邮箱登陆
    * @param $mobile   string 手机号
    * @param $password string 密码
    * @return array
    */
    /*
    *注册的时候，验证用户邮箱或手机号是否已使用
    * @param $mobile   string 手机号
    * @param $email    string 邮箱
    * @return boolean
    */
    function checkUserExists($mobile,$email){
        $this->db->where('Mobile',$mobile);
        $this->db->or_where('Email',$email);
        $query = $this->db->get('Tbl_Member');
        $data = $query->result_array();
        $userExists = $data?true:false;
        return $userExists;
    }
    /*
    *新增用户
    * @param $Mobile   string 手机号
    * @param $Email    string 邮箱
    * @param $Name     string 姓名
    * @param $Gender   int    性别
    * @param $Grade    int    手机号
    * @param $School   string 学校
    * @param $Password string 密码
    * @return array
    */
    function addUser($Mobile,$Email,$Name,$Gender,$Grade,$School,$Password,$CreateTime){
        $array = array(
            'Mobile'=>$Mobile, 
            'Email'=>$Email, 
            'Name'=>$Name,
            'Gender'=>$Gender,
            'Grade'=>$Grade,
            'School'=>$School,
            'Password'=>$Password,
            'CreateTime'=>$CreateTime,
        ); 
        $this->db->set($array); 
        $data = $this->db->insert('Tbl_Member');
        return $data;   
    }
    /*
    *激活账户
    * @param $mobile   string 手机号
    * @param $email    string 邮箱
    * @return 
    */
    public function updateActivated($mobile){
    	$this->db->where('Mobile',$mobile);
    	$this->db->update('Tbl_Member',array('Activated'=>1));
    }

    public function checkLogin(){
        $userInfo = $this->session->userdata('userInfo');
        //未登录跳转
        if(!$userInfo){
            return array();
        }
        $userInfo = json_decode($userInfo,true);
        //登陆以后查看用户是否已购买该课程
        return $userInfo;
    }
}
?>