<?php
class Order extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ClassModel');
        $this->load->model('UserModel');
        $this->load->model('CommonModel');
        $this->load->model('OrderModel');
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
        $classInfo = $this->ClassModel->getVideoByClassID($classID);
        $MemberID = $userInfo['MemberID'];
        $OrderNo = date('Ymd').str_pad($MemberID, 6, '0', STR_PAD_LEFT).str_pad($classID, 6, '0', STR_PAD_LEFT);
        $OrderArr = array(
            'OrderNo' => $OrderNo,
            'MemberID' => $MemberID,
            'ClassID' => $classID,
            'Price' => $classInfo['Price'],
            'CreateTime' => date('Y-m-d H:i:s'),
            'UpdateTime' => date('Y-m-d H:i:s'),
            'Status' => 0,
            'PaymentType' => 1,//1支付宝
        );
        
        $rs = $this->OrderModel->createOrder($OrderArr,0);
        if(!$rs){

        }else{
            $where = array('OrderNo'=>$OrderNo);
            $data['orderInfo'] = $this->OrderModel->getOrderInfo($where);
            $data['classInfo'] = $this->ClassModel->getVideoByClassID($classID);
            unset($data['classInfo']['Video']);
            $this->load->view('/order/createOrder',$data);

        }
     var_dump($data);
    }
}
