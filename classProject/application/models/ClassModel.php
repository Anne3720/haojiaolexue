<?php
/**
*课程类
*/
class ClassModel extends CI_Model{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /*
    * 获取所有科目
	* @return array
    */
    public function getSubjectList(){
    	$this->db->select('*');
		$query = $this->db->get('Tbl_Subject');
        $data = $query->result_array();
		return $data;
    }
    /*
    * 获取课程视频地址
	* @param $classid     int  课程ID
	* @return array
    */
    public function getVideoByClassID($classid){
    	$this->db->select('ClassID,ClassNo,Name,Grade,Image,Desc,SubjectID,Price,Teacher,Video,UpdateTime');
		$this->db->where('ClassID',$classid);
		$query = $this->db->get('Tbl_Class');
        $data = $query->result_array();
		return isset($data[0])?$data[0]:array();
    }
    /*
    * 检验用户是否已购买该视频
	* @param $MemberID    int  用户ID
	* @param $classid     int  课程ID
	* @return array
    */
    public function checkClassBought($MemberID,$classid){
		$this->db->where('MemberID',$MemberID);
		$this->db->where('ClassID',$classid);
		$query = $this->db->get('Tbl_ChosenClass');
        $data = $query->result_array();
		return isset($data[0])?true:false;
    }
    /*
    * 获取用户课程的IDs
    * @param $MemberID     int  课程ID
    * @return array
    */
    public function getClassIds($where,$type){
        $this->db->select('ClassID');
        foreach ($where as $key => $value) {
            $this->db->where($key,$value);
        }
        if($type=="recommend"){
            $table = "Tbl_RecommendClass";
        }elseif($type=="chosen"){
            $table = "Tbl_ChosenClass";
        }
        $query = $this->db->get($table);
        $IdsArray = $query->result_array();
        foreach ($IdsArray as $key => $value) {
            $data[] = $value['ClassID'];
        }
        return $data;
    }
    /*
    * 获取课程列表
    * @param $offset     int  查询偏移量
    * @param $limit      int  查询条数
    * @param $where      array查询条件
    * @return array
    */
    public function getClassList($offset,$limit,$where){
        $this->db->select('ClassID,ClassNo,Name,Grade,Image,Desc,SubjectID,Price');
        foreach ($where as $key => $value) {
            $this->db->where($key,$value);
        }
        $this->db->limit($limit,$offset);
        $query = $this->db->get('Tbl_Class');
        $data = $query->result_array();
        return $data;
    }
    /*
    * 获取课程总数
    * @param $where    array   查询条件
    * @return array
    */
    public function getClassTotal($where){
        foreach ($where as $key => $value) {
            $this->db->where($key,$value);
        }
        $num = $this->db->count_all_results('Tbl_Class');
        return $num;
    }
    /*
    * 获取课程列表
    * @param $where    array   查询条件
    * @return array
    */
    public function getMyClassList($where_in){
        $this->db->select('ClassID,ClassNo,Name,Grade,Image,Desc,SubjectID,Price');
        // foreach ($where as $key => $value) {
        //     $this->db->where($key,$value);
        // }
        foreach ($where_in as $key => $value) {
            $this->db->where_in($key,$value);
        }
        $this->db->order_by("ClassID","desc");
        $query = $this->db->get('Tbl_Class');
        $data = $query->result_array();
        return $data;
    }
}
?>