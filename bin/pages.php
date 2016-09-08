<?php
    include "public.php";
    class Pages{
        public $pageSize;
        public $pageCount;
        public $pageNumber;
        private $query;
        private $db;
        private $result;


        public function __construct($_query, $_pageSize=10, $_pageNumber=1){
            $this->query = $_query;
            $this->pageSize = $_pageSize;
            $this->pageNumber = $_pageNumber;
        }
        public function select($_query="", $_pageSize=-1, $_pageNumber=-1){
            if($_query=="")$_query = $this->query;
            if($_pageSize==-1)$_pageSize = $this->pageSize;
            if($_pageNumber==-1)$_pageNumber = $this->pageNumber;
            if($_query=="")return null;
            $startline = ($this->pageNumber-1) * $this->pageSize;
            $_query = $_query." LIMIT ".$startline.",".$this->pageSize;
            return getJsonBySql($_query);
        }


    }



?>