<?php
/**
* 订单类
*/
class OrderModel extends CI_Model {
    //请求返回
    public function createOrder($OrderArr,$type=0){
        $this->db->set($OrderArr); 
        $data = $this->db->insert('Tbl_Order');
        return $data; 
    }

    public function getOrderInfo($where){
        $this->db->select('*');
        foreach ($where as $key => $value) {
            $this->db->where($key,$value);
        }
        $this->db->order_by('OrderID','DESC');
        $this->db->limit(1);
        $query = $this->db->get('Tbl_Order');
        $data = $query->result_array();
        return isset($data[0])?$data[0]:array();
    }
}