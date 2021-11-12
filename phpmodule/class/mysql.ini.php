<?php

class mysqlAbstract{

}

class mysql extends mysqlAbstract{

	public $host ; 
	public $port = 3306; 
	public $user ; 
	public $password ; 
	public $dbName ; 
	public $mdb ; 
	public $res ; 

	public $debug_query = "N";
	public $debug_record = "N";
	public $queryArr ; 

	function connect(){
		$this->mdb = new mysqli($this->host, $this->user, $this->password, $this->dbName, $this->port );
		$this->query("SET CHARACTER SET UTF8");
		if($this->mdb->connect_error){
			require_once dirname(__FILE__)."/log.ini.php";
			$log = new log() ; 
			$log->errLog("Connect Err : ".$this->mdb->connect_errno." - ". $this->mdb->connect_error ); 
			return false ; 
		}
		return true;
	}

	function query($query){

		
		$this->connectChk();
		if(!$this->res = $this->mdb->query($query)){
			require_once dirname(__FILE__)."/log.ini.php";
			$log = new log() ; 
			$log->errLog("Query Err : " . $this->mdb->error ); 
			return false ; 
		}
		//$this->res->close();
		if($this->debug_query == "Y"){
			echo "\n\n\n";
			echo "This is DB Debug Mode : \n";
			echo $query ; 	
			echo "\n";
		}

		$this->queryAssign('query',$query);

		return true ; 
	}
	
	function explainQuery($query){

		
		$this->connectChk();
		if(!$this->res = $this->mdb->query($query)){
			return false ; 
		}
		//$this->res->close();
		if($this->debug_query == "Y"){
			echo "\n\n\n";
			echo "This is DB Debug Mode : \n";
			echo $query ; 	
			echo "\n";
		}

		$this->queryAssign('query',$query);

		return true ; 
	}

	function queryEx($query){
		
		$this->connectChk();
		if(!$this->res = $this->mdb->query($query)){
			require_once dirname(__FILE__)."/log.ini.php";
			$log = new log() ; 
			$log->errLog("Query Err : " . $this->mdb->error ); 
			return $this->mdb->error ; 
		}
		//$this->res->close();
		if($this->debug_query == "Y"){
			echo "\n\n\n";
			echo "This is DB Debug Mode : \n";
			echo $query ; 	
			echo "\n";
		}

		$this->queryAssign('query',$query);

		return true ; 
	}

	function getRecord(){
		$rows = array();
		if($this->res){
			while($row = $this->res->fetch_assoc())
			{
				$rows[] = $row;
			}
		}
		if($this->debug_record == "Y"){
			echo "This is Record Debug Mode : \n";
			print_r($rows);
		}
		return $rows ; 
	}
	
	function getQueryRecord($query){
		$this->queryAssign('getQueryRecord',$query);
		$res = $this->query($query);
		$result["table"]["record"] = $this->getRecord();
		return $result ; 
	}	

	function getRow(){
		$rows = 0;
		if($this->res){
			$rows = $this->res->num_rows;
		}
		return $rows ; 
	}
	
	// max_page : 一頁多少筆 ,  max_range : 多少頁數 , 一個RANGE
	function recordPage($rows,$page,$max_page,$max_range){
		if($page == 0 || $page == "" ){
			$page = 1; 
		}
		$lastpage = ceil($rows/$max_page);
                if($page > $lastpage){  
			$page=1 ;
		}
                $rec_start= ($page-1)*$max_page +1;
                $rec_end  = $rec_start + $max_page -1;

                $ploops   = floor(($page-1)/$max_range)*$max_range + 1 ;
                $ploope   = $ploops + $max_range -1;
                if($ploope >= $lastpage){ $ploope=$lastpage;}

                $ppg      = $page - 1 ;
                $npg      = $page + 1 ;
                if($ppg<= 0) $ppg=$lastpage;
                if($npg > $lastpage) $npg=1;
                if($rec_end > $rows) $rec_end=$rows;

                $arr["rec_start"]       = $rec_start ;
                $arr["rec_end"]         = $rec_end ;
		$arr["firstpage"] 	= 1;		// 第一頁
		$arr["lastpage"] 	= $lastpage;	// 最後一頁 的頁數
		$arr["previousrange"] 	= $ploops - $max_range ; 
                $arr["nextrange"]       = $ploops + $max_range ;
	        $arr["previouspage"]    = $ppg ;
                $arr["nextpage"]        = $npg ;
	        $arr["thispage"]        = $page ;
                $arr["total"]           = $rows ;
                $arr["totalpage"]       = $lastpage ;
                for($i=$ploops;$i <= $ploope;$i++){
                        $arr["page"]["item"][]["p"] = $i ;
                }
                return $arr;
	}

	function escapeString($str){
		$this->connectChk();
		return $this->mdb->real_escape_string($str);
	}


	function getInsertId(){
		$this->connectChk();
		return $this->mdb->insert_id;
	}

	function getAffectedRows(){
		$this->connectChk();
		return $this->mdb->affected_rows;
	}

	function mdbClose(){
		$this->mdb->close();
	}

	function resClose(){
		$this->res->close();
	}



        function queryAssign($type , $query){
                $this->queryArr[$type][] = $query ;
        }


	function connectChk(){
		if(!$this->mdb){
			include_once dirname(__FILE__)."/log.ini.php";
			$log = new log() ; 
			$log->errLog("Query Err : Programe not call obj->connect()" ); 
			echo 'Please call obj->connect() !'; exit ; 
		}
	}




}

?>
