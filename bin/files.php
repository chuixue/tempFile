<?php
    header('Content-Type:text/html; charset=utf8');
	//include "public.php";
    include "pages.php";


	$key=@$_GET['key'];			//请求的关键字
	$query=json_decode(@$_GET['data']);	//附带的数据
	$rst = new RST();			//待返回数据
	$data = new OBJ();          //临时变量

    //分类处理
    if($key=="files"){
        $pz = (!@$query->pageSize) ? PAGE_SIZE : $query->pageSize;
        $pn = (!@$query->pageNumber) ? 1 : $query->pageNumber;
        $sql = "select * from file";
        $pg = new Pages($sql, $pz, $pn);
        $data = $pg->select();

        $rst->message = $pn;

    }
    $rst->data=$data;
    echo urldecode(@$_GET['callback'].'('.json_encode($rst).')');
    exit;


?>