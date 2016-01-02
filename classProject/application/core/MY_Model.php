<?php
class MY_Model extends CI_Model {
	
	public  $dbconfigkey="";//数据库连接对象配置key
	public $dbname="";//数据库名称，可以为空，如果是空使用连接对象中的默认值
	public $dbtable="";//表名称，在执行sql之前不可以为空
	public $db="";//数据库主库连接对象
	public $read_db="";//数据库从库连接对象
	
	function __construct()
	{
		parent::__construct();
		$this->setdb();
	}
	/*
	 * 获取配置文件选择数据库连接值
	 * */
	function setdb($dbconfigkey="",$isreturn=FALSE,$dataname="")
	{
		if ($dbconfigkey=="")
		{
			$dbconfigkey=$this->dbconfigkey;
		}
		if ($dbconfigkey)//如果存在则进行数据库连接
		{
			$this->config->load("database");
			$database=$this->config->item('database');
			if (isset($database[$this->dbconfigkey]))
			{
				$Master="";
				$readdb="";
				foreach($database[$this->dbconfigkey] as $val)
				{
					if ($this->dbname!="")
					{
						$val['database']=$this->dbname;
					}
					if ($dataname)
					{
						$val['database']=$dataname;
					}
					if ($val['isMaster'])
					{
						unset($val['isMaster']);
						
						$Master=$val;
					}else
					{
						unset($val['isMaster']);
						$readdb[]=$val;
					}
				}
				//连接主库获得主库连接
				$mdb=$this->load->database($Master,true);
				if($readdb)
				{
					$sdb=$this->load->database($readdb[rand(0,(count($readdb)-1))],true);
				}
				else //当没有从库的时候，从库用主库的链接对象
				{
					$sdb=$mdb;
				}
				if ($isreturn)
				{
					$dbarray=array('mdb'=>$mdb,'sdb'=>$sdb);
					return $dbarray;
				}else 
				{
					$this->db=$mdb;
					$this->read_db=$sdb;
				}
			}else 
			{
				show_error('对不起没要找到可用的连接');
			}
			//1、获取主库连接对象
		}
	}
	/*
	 *读取一条数据 
	 */
	function getOne($where="",$find="*",$orderby="",$dbtable="",$db="",$isMaster=FALSE)
	{
			if (!$dbtable)
			{
				$dbtable=$this->dbtable;
			}
			if ($db=="")
			{
				$db=array("mdb"=>$this->db,'sdb'=>$this->read_db);
			}
			if(!$db)
			{
				show_error("请线连接数据库！");
			}
			if ($isMaster)
			{
				$db=$db['mdb'];
			}else
			{
				$db=$db['sdb'];
			}
			if ($where)
			{
				$db->where($where);
			}
			if ($find=="")
			{
				$find="*";
			}
			$db->select($find);
			if ($orderby)
			{
				$db->order_by($orderby);
			}
			$query = $db->get($dbtable);

			return $query->row_array();
	}
	//获取所有数据信息
	function getAll($where="",$find="*",$orderby="",$groupby="",$limit="",$dbtable="",$db="",$isMaster=FALSE)
	{
		
			if (!$dbtable)
			{
				$dbtable=$this->dbtable;
			}
			if ($db=="")
			{
				$db=array("mdb"=>$this->db,'sdb'=>$this->read_db);
			}
			if(!$db)
			{
				show_error("请线连接数据库！");
			}
			if ($isMaster)
			{
				$db=$db['mdb'];
			}else
			{
				$db=$db['sdb'];
			}
			if ($where)
			{
				$db->where($where);
			}
			if ($find=="")
			{
				$find="*";
			}
			$db->select($find);
			if ($orderby)
			{
				$db->order_by($orderby);
			}
			if ($groupby)
			{
				$db->group_by($groupby);
			}			
			if ($limit)
			{
				$limit=explode(",", $limit);
				if(count($limit)==1)
				{
					$db->limit($limit[0]);
				}else if(count($limit)==2)
				{
					$db->limit($limit[1],$limit[0]);
				}
			}
			$query = $db->get($dbtable);
			return $query->result_array();
	}
	
	//批量插入数据，必须传输二维数组
	function insertAll($data,$updata="",$dbtable="",$db="")
	{
		
		if (!count($data))
		{
			return 0;
		}
		if (!$dbtable)
		{
			$dbtable=$this->dbtable;
		}
		if (!$db)
		{
			$db=$this->db;
		}elseif(isset($db['mdb']))
		{
			$db=$db['mdb'];
		}else{
			show_error("没有指定可操作的主库");
		}
		$sql="insert into $dbtable  ";
		$findname="(";
		$valuesStr="";
		$m=0;
		foreach($data as $val)
		{
			
			$valuesStr.=" (";
			if (!is_array($val))
			{
				show_error("您添加的数据结构不正确必须是二维数组");
			}
			foreach($val as $key=>$var)
			{
				if ($m==0)
				{
					$findname.="`$key`,";
				}
				$valuesStr.="'".addslashes($var)."',";
			}
			$valuesStr=substr($valuesStr, 0,-1);
			$valuesStr.="),";
			$m++;
		}
		$findname=substr($findname, 0,-1);
		$valuesStr=substr($valuesStr,0,-1);
		$findname.=")";
		$sql.=$findname." values ".$valuesStr;
		if($updata)
		{
			$sql.=" on duplicate key update";
			foreach ($updata as  $key=>$val)
			{
				if ($key==$val)
				{
					$sql.=" $key=values($val),";
				}else 
				{
					$sql.=" $key=$val,";
				}
			}
			$sql=substr($sql, 0,-1);
		}
		$returndata['ifok']=$db->query($sql);
		$returndata['count']=$db->affected_rows();
		unset($sql);
		return $returndata;
	}
	
	//更讯数据
	function update($data,$where="",$dbtable="",$db="")
	{
		if (!count($data))
		{
			return 0;
		}
		if (!$dbtable)
		{
			$dbtable=$this->dbtable;
		}
		if (!$db)
		{
			$db=$this->db;
		}elseif(isset($db['mdb']))
		{
			$db=$db['mdb'];
		}else{
			show_error("没有指定可操作的主库");
		}
		$returndata=array();
		if ($where)
		{
			$db->$where($where);
		}
		$returndata['ifok']=$db->update($dbtable, $data); 
		$returndata['count']=$db->affected_rows();
		return $returndata;
	}
	//删除数据
	function delete($where="",$dbtable="",$db="")
	{
		
		if (!$dbtable)
		{
			$dbtable=$this->dbtable;
		}
		if (!$db)
		{
			$db=$this->db;
		}elseif(isset($db['mdb']))
		{
			$db=$db['mdb'];
		}else{
			show_error("没有指定可操作的主库");
		}
		$returndata=array();
		$returndata['ifok']=$db->delete($dbtable, $where);
		//$db->last_query();
		$returndata['count']=$db->affected_rows();
		return $returndata;
	}
	
	//自定义sql
	function dosql($sql="",$key="",$dbtable="",$db="",$isMaster=FALSE)
	{
		if (!$dbtable)
		{
			$dbtable=$this->dbtable;
		}
		if ($db=="")
		{
			$db=array("mdb"=>$this->db,'sdb'=>$this->read_db);
		}
		if(!$db)
		{
			show_error("请线连接数据库！");
		}
		if ($isMaster)
		{
			$db=$db['mdb'];
		}else
		{
			$db=$db['sdb'];
		}
		$data = array();
		$query = $db->query($sql);
		if (is_object($query))
		{
			if($key)
			{
				foreach ($query->result() as $row)
				{
					$result = get_object_vars($row);
					$inx = $result[$key];
					$data[$inx] = $result;
				}
			}
			else
			{
				foreach ($query->result() as $row)
				{
					$data[] = get_object_vars($row);
				}
			}
		}
		return $data;
	}
	
	function __destruct()
	{
		
	}
	
}