<?php
    include "database.php";
    class OBJ{};		//空对象
    //通用响应格式
	class RST{
		public $error=0;     	//是否出错
		public $message="OK";	//错误信息或其它
		public $data;		//结果，为JSON格式
		public $newID=-1;	//插入新记录的id，用于带有更新数据的请求
	};

    function getJsonBySql($sql)
 	{
 		$db = new Database();
 		$records = $db->Select($sql);
 		$all = array();
 		while($rec = mysql_fetch_array($records))
 		{
 			$p = new OBJ();
 			foreach($rec as $key => $value)
 			{
 				if(!is_numeric($key)){
 					$p->$key = urlencode($value);
 					//print "$key => $value\n";
 				}
 			}
 			array_push($all, $p);
 		}
 		return $all;
 	}
 	function run($sql, &$ID=-1)
 	{
 		$db = new Database();
 		$rst = $db->Select($sql);
 		if($ID!=-1)$ID = $db->GetInsertID();
 		return $rst;
 	}



?>