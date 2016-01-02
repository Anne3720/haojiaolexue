<?php
/**
* 公共model类
*/
class CommonModel extends CI_Model {
    //请求返回
    public function sendMsg($status,$data,$msg){
        $return = array(
            'status'=>$status,
            'data'=>$data,
            'msg'=>$msg
        );
        echo(json_encode($return));
        exit;
    }
    //发送邮件
    public function sendSimpleEmail($from,$to,$subject,$message,$emailConfig){
        $this->load->library('email');
        $this->email->initialize($emailConfig);          
        $this->email->from($from, 'fanteathy');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();
    }
}