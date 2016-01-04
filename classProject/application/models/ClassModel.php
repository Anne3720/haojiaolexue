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
    	$this->db->select('Video');
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
    * 获取用户已购买课程
	* @param $MemberID     int  课程ID
	* @return array
    */
    public function getMyClass($MemberID){
    	$sql = "select A.MemberID,A.ClassID,B.ClassNo,B.Image,B.Video,B.Price
    	        from Tbl_ChosenClass A left join Tbl_Class B 
    	        on A.ClassID=B.ClassID
    	        ";
		$query = $this->db->query($sql);
        $data = $query->result_array();
		return isset($data[0])?true:false;
    }
    /*
    * 获取课程列表
    * @param $offset     int  查询偏移量
    * @param $limit      int  查询条数
    * @param $where      array查询条件
    * @return array
    */
    public function getClassList($offset,$limit,$where){
        $this->db->select('ClassID,ClassNo,Grade,Image,SubjectID,Price');
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
}
?>