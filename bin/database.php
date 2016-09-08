<?php
    header('Content-Type:text/html; charset=utf8');
    include '../conf/conf.php';
    class Database
    	{
    		public $dbHost = DB_HOST;       //数据库地址
     		public $dbUser = DB_USER;       //用户
     		public $dbPasswd = DB_PASSWORD; //密码
     		public $dbName = DB_DATABASE;   //数据库名
     		public $dbPort = DB_PORT;       //端口
    		public $conn;		            //数据库连接
    		public $selDB=false;
    		public $debug=false;
            public $result = null;

    		function __construct($path="")
    		{
    			$this->connect();
       		}
       		public function __destruct(){
                if($this->result)mysql_free_result($this->result);
                if($this->conn)mysql_close($this->conn);
             }

       		//连接数据库
        	public function connect($_dbName="", $charset='utf8')
        	{
                $this->conn=@mysql_connect($this->dbHost.":".$this->dbPort, $this->dbUser, $this->dbPasswd);
                if(!$this->conn)
                {
                    $this->DealError(101);
                    return false;
                }
                $this->SelectDB($_dbName);
            	@mysql_query("set names ".$charset);
    			//mysql_query("set character_set_client=utf8");
    			//mysql_query("set character_set_results=utf8");
    	        return $this->conn;
            }
            //选择数据库
            public function SelectDB($_dbName="")
            {
                $db = ($_dbName=="") ? $this->dbName : $_dbName;
            	$rst=@mysql_select_db($db, $this->conn);
            	if(!$rst)$this->DealError(103);
    			$this->selDB=true;
            	return $rst;
            }
            //执行
            public function Execute($_sql, $charset='utf8')
            {
            	return $this->Select($_sql, $charset);
            }
            //查询
            public function Select($_sql, $charset='utf8')
            {
    			if(!$this->selDB)
    			{
    				$this->SelectDB();
    				$this->selDB=true;
    			}
            	@mysql_query("set character set ".$charset);
    			if($this->debug)echo "<pre>Query:".$_sql .".</pre>";
            	$rst = mysql_query($_sql, $this->conn);
            	if($rst==false) $this->DealError(202); else{ if($this->debug)echo "OK!";}
            	return $rst;
            }
    		public function GetInsertID()
    		{
    			return mysql_insert_id();
    		}
            public function GetAllTable($tbName)
            {
            	return $this->Select("select * from ".$tbName);
            }
    		public function DealError($error_numb,$error_text="",$sql="")
      		{
    			$e = @mysql_error();
    			$eu = mb_convert_encoding($e, "UTF-8", "GBK");
      			if(trim($e)!="")echo $eu."<br/>";
      			if($error_numb<200)exit();
      		}

    		function CreateDB($dbName="")
    		{
    			$this->selDB=true;
    			$dbn = $dbName!=""? $dbn: $this->dbName;
    			$sql='CREATE DATABASE IF NOT EXISTS '.$dbn.' DEFAULT CHARSET utf8 COLLATE utf8_general_ci';
    			$this->Execute($sql);
    			$db=($dbName=="") ? $this->dbName : $dbName;
               	if($db!="")@mysql_select_db($db, $this->conn);
    		}

    		function QueryAll($sql1, $sql2, &$id1=-1)
    		{
    			$this->Select('SET AUTOCOMMIT=0'); // 设置为不自动提交查询
    			$this->Select('START TRANSACTION'); // 开始查询，这里也可以使用BEGIN
    			$rst1=$this->Select($sql1);
    			$rst=false;
    			if($rst1!=false)
    			{
    				$id1=mysql_insert_id();
    				$rst2=$this->Select($sql2);
    				if($rst2==false)
    				{
    					$id1=-1;
    					mysql_query('ROLLBACK');
    				}
    				else
    					$rst=true;
    			}
    			mysql_query('COMMIT');
    			return $rst;
    		}
    		function QueryAllSql(&$sql)
    		{
    			$this->Select('SET AUTOCOMMIT=0'); // 设置为不自动提交查询
    			$this->Select('START TRANSACTION'); // 开始查询，这里也可以使用BEGIN
    			$RSTS = array();
    			for($i=0;$i<count($sql);$i++)
    			{
    				$RSTS[$i] = $this->Select($sql[$i]);
    			}
    			$rst=true;
    			for($i=0;$i<count($rst);$i++)
    			{
    				if($RSTS[$i]==false){ $rst=false; break; }
    			}
    			if(!$rst)mysql_query('ROLLBACK');
    			mysql_query('COMMIT');
    			return $rst;
    		}
    		function QueryAllEx($sql1, $sql2, &$data ,$user, &$id1=-1)
    		{
    			$this->Select('SET AUTOCOMMIT=0'); // 设置为不自动提交查询
    			$this->Select('START TRANSACTION'); // 开始查询，这里也可以使用BEGIN
    			$rst1=$this->Select($sql1);
    			$rst=false;
    			if($rst1!=false)
    			{
    				$id1 = mysql_insert_id();
    				for($i=0; $i<count($data); $i++)
    				{
    					$sql2.="(".$id1.",".($i+1).",'".$data[$i]."','".$user."')";
    					if($i<count($data)-1)$sql2.=",";
    				}
    				$rst2 = $this->Select($sql2);
    				if($rst2==false)
    				{
    					$id1=-1;
    					mysql_query('ROLLBACK');
    				}
    				else
    					$rst=true;
    			}
    			mysql_query('COMMIT');
    			return $rst;
    		}

    	}


?>