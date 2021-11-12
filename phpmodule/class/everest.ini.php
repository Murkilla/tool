<?php

class initClasse {
	public $io ; 
	public $config ; 
	public $path ; 
	function __construct() {
		$this->config = new config();
		$this->str = new stringConvert();
		$this->http = new Http();
		$this->http->setHeader($this->config->default_charset) ;
		$this->io = new intputOutput();
		$this->path = new patchControl();
		$this->setPath();
		//$this->session = new MemSession();

	}

	function loginChk() {
		if (empty($this->io->input['session']['user'])) {
			// header("location:".$this->config->default_main.'/admin');
			// die();
			header("location:/tool/login");
		}
		if($this->io->input['session']['role']['rid'] != 'admin'){
			$this->checkPermission();
		}
		
	}

	function adminLoginChk() {
		if (empty($this->io->input['session']['admin'])) {
			// header("location:".$this->config->default_main.'/admin');
			// die();
		}
	}

	function checkPermission(){
		if(!isset($this->io->input['get']['fun'])) return;
		$fun = $this->io->input['get']['fun'];
		$act = $this->io->input['get']['act'];
		$msg = '無操作權限';
		//if($act == 'table' && isset($this->io->input['get']['search'])) $act = 'search';
		if($fun == 'login' || $fun == 'log' || $fun == 'block' || $fun == 'logout' || $fun == 'onload' || $fun == 'forget_pass') return ;
		if($act != 'view' ) return;

		if($act == 'search') $msg = '';

		$permission = $this->getPermission($fun);
		if(!is_array($permission) || count($permission) == 0){
			$this->jsAlertMsg($msg);
		}

		$chk = false;

		foreach($permission as $v){
			if($v['fid'] == $fun && $v[$act] == 'Y'){
				$chk = true;
				break;
			}
		}

		if(!$chk){
			$this->jsAlertMsg($msg);
		}

	}

	function getPermission($fid = ''){
		require_once dirname(__FILE__)."/mysql.ini.php";
		$model = new mysql();
		$model->host = $this->config->db[0]['host'];
		$model->user = $this->config->db[0]['username'];
		$model->password = $this->config->db[0]['password'];
		$model->dbName = $this->config->db[0]['db_name_0'];
		$model->connect();

		$uid = 0;
		if(isset($this->io->input['session']['user']['uid'])) $uid = $this->io->input['session']['user']['uid'];
		else if(isset($_SESSION['user']['uid'])) $uid = $_SESSION['user']['uid'];

		if($uid == 0) return array();

		$query = "select rf.`fid`,
			(case when sum(case when rf.`view` = 'Y' then 1 else 0 end) > 0 then 'Y' else 'N' end ) as `view`,
			(case when sum(case when rf.`add` = 'Y' then 1 else 0 end) > 0 then 'Y' else 'N' end ) as `add`,
			(case when sum(case when rf.`edit` = 'Y' then 1 else 0 end) > 0 then 'Y' else 'N' end ) as `edit`,
			(case when sum(case when rf.`delete` = 'Y' then 1 else 0 end) > 0 then 'Y' else 'N' end ) as `delete`
			from `".$this->config->db[0]['db_name_0']."`.`".$this->config->db[0]['prefixid_table']."_role_fun_rt` rf 
			left join 
			`".$this->config->db[0]['db_name_0']."`.`".$this->config->db[0]['prefixid_table']."_fun` f 
			on 
			rf.`prefixid` = f.`prefixid` 
			and rf.`fid` = f.`fid` 
			and rf.`switch` = f.`switch` 
			left join 
			`".$this->config->db[0]['db_name_0']."`.`".$this->config->db[0]['prefixid_table']."_role_user_rt` ru 
			on 
			rf.`prefixid` = ru.`prefixid`
			and rf.`rid` = ru.`rid`  
			and rf.`switch` = ru.`switch`
			left join 
			`".$this->config->db[0]['db_name_0']."`.`".$this->config->db[0]['prefixid_table']."_role` r 
			on 
			ru.`prefixid` = r.`prefixid` 
			and ru.`rid` = r.`rid` 
			and ru.`switch` = r.`switch`  
			where 
			rf.`prefixid` = '".$this->config->db[0]['prefixid_index']."' 
			and ru.`uid` = '".$uid."' 
			and rf.`switch` = 'Y' 
			".(!empty($fid)? "and f.`fid` = '".$fid."'" : '')."
			and f.`prefixid` is not null
			and ru.`prefixid` is not null
			and r.`prefixid` is not null
			group by rf.`fid` ";
		$permission = $model->getQueryRecord($query);

		if(!is_array($permission['table']['record'])){
			$permission['table']['record'] = array();
		}

		return $permission['table']['record'];
	}

	function setPath(){
		$this->path->getTplFile($this->io->input,$this->config->path_style,$this->config->default_template);
		$this->path->getSourcesFile($this->io->input,$this->config->path_sources);

		if(!isset($this->io->input["get"]["act"]) and !isset($this->io->input["get"]["fun"])){
			$this->io->input["get"]["act"] = 'view';
		}



		if(isset($this->io->input["get"]["act"]) or isset($this->io->input["get"]["fun"])){
			include_once $this->path->sourcesfile ; 	
		}
	}

	function display(){
		//$this->tplVar["status"] = array();
		$this->tplVar["status"]["get"] = $this->io->input["get"] ;
		$this->tplVar["status"]["post"] = $this->io->input["post"] ;
		$this->tplVar["status"]["session"] = $_SESSION ;

		if (!isset($this->tplVar["status"]["path"])) {
			$this->tplVar["status"]["path"] = '';
		}		
		if (!isset($this->tplVar["status"]["search_path"])) {
			$this->tplVar["status"]["search_path"] = '';
		}
		if (!isset($this->tplVar["status"]["sort_path"])) {
			$this->tplVar["status"]["sort_path"] = '';
		}
		if (!isset($this->tplVar["status"]["p"])) {
			$this->tplVar["status"]["p"] = '';
		}
		$this->tplVar["status"]["base_href"] = $this->tplVar["status"]["path"]
																				. $this->tplVar["status"]["search_path"]
																				. $this->tplVar["status"]["sort_path"]
																				. $this->tplVar["status"]["p"];

    $this->assignBlockPath("head");
    $this->assignBlockPath("header");
    $this->assignBlockPath("breadcrumb");
    $this->assignBlockPath("right");
    $this->assignBlockPath("left");
    $this->assignBlockPath("path");
    $this->assignBlockPath("center");
    $this->assignBlockPath("footer");
    $this->assignBlockPath("page");

		//echo "<pre>"; print_r($this); exit ;
		if(isset($this->io->input["get"]["get_json"]) && $this->io->input["get"]["get_json"] == 'Y'){
			echo json_encode($this->tplVar); exit ;
		}

		if(isset($this->io->input["get"]["show_me_the_var"]) && $this->io->input["get"]["show_me_the_var"] == 'Y'){
			echo "<pre>";
			print_r($this->tplVar); exit ;
		}

		if(isset($this->io->input["get"]["show_me_the_sql"]) && $this->io->input["get"]["show_me_the_sql"] == 'Y'){
			echo "<pre>";
			print_r($this->model->queryArr); exit ;
		}


		include_once $this->path->tplfile  ; 	
	}

	function tplVar($type , $arr){

		
		$this->tplVar[$type] = $arr ; 
		
	}

        function assignBlockPath($tpl_name){
                $template = $this->config->default_template;
                if (isset($this->io->input["get"]["tpl"]) && $this->io->input["get"]["tpl"]) {
                        $template = $this->io->input["get"]["tpl"];
                }
                $this->path->getBlcokPath($tpl_name,$this->config->path_style,$template);
		$this->tplVar('block',$this->path->blockpath);
        }

	function includeBlock($tpl_path){
		include_once $tpl_path;
	}

        function getLanguageMain($pid=''){
		//echo "<pre>";		print_r($this->config); exit ;
		$query ="
                SELECT  
		*
                FROM `".$this->config->db[1]["dbname"]."`.`".$this->config->default_prefix."language_main` 
		where 
		prefixid = '".$this->config->default_prefix_id."' and 
		lanid = '".$this->config->default_lang."' and 
		pid = '".$pid."'
		order by vid
		";
		//echo $query ; exit ;
		//echo "<pre>"; 		print_r($this); exit ;
		return $this->language_main = $this->model->getQueryRecord($query) ; 


	}



	function messageConvert($msg){
		$message = "";
		$this->getLanguageMain($this->config->project_id);
		//echo "<pre>";	print_r($this->language_main);
		if(isset($this->language_main["table"]["record"])){
			if(is_array($this->language_main["table"]["record"])){
				foreach($this->language_main["table"]["record"] as $rk => $rv){
					if($msg == $rv["vid"]){
						$message =  $rv["value"] ; 
					}
				}
			}
		}
		if($message == ''){
			$message = $msg ; 
		}
		return $message ; 
		//echo "<pre>"; print_r($obj->lang->language_main["table"]["record"]); exit ;

	}

	function ajaxRes($msg, $errCode = 0, $arr = array()){
		$res = array('message' => $msg, 'error' => $errCode);
		if(is_array($arr) && count($arr) > 0){
			$res = array_merge($res, $arr);
		}
		if(isset($_SERVER['HTTP_X_AJAX_METHOD'])){
			echo  '[AJAX_RES_START]'.$this->jsonRemoveUnicodeSequences($res).'[AJAX_RES_END]';
		}else if(isset($_SERVER['HTTP_X_AJAX_LOAD'])){
			if($errCode > 0){
				//http_response_code(412);
				header(':', true, 412);
			}
			echo $msg;
		}else{
			echo $msg;
		}
		exit;
	}

	function jsonRemoveUnicodeSequences($struct) {
		$ver = explode('.', PHP_VERSION);
		$ver_id = $ver[0] * 10000 + $ver[1] * 100;
		if($ver_id < 50400){
		   return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct));
		}else{
			return json_encode($struct, JSON_UNESCAPED_UNICODE);
		}
	}


	function printMsg($msg=""){
		if(isset($_SESSION["wrong_num"])){
			echo $this->messageConvert($msg).",".$msg.",".$_SESSION["wrong_num"] ; exit ;
		}
		else{
			echo $this->messageConvert($msg).",".$msg ; exit ;
		}
	}
	


	function jsPrintMsg($msg,$location_url){
		echo "
			<html>
			<head>
			<script type=\"text/javascript\">
			<!--
				alert('".$msg."');
				location.href = '".urldecode(base64_Decode($location_url))."' ; 
			-->	
			</script>
			</head>
			</html>
		";
		exit ; 
	}
	function jsAlertMsg($msg, $msgid = ""){
		if (empty($this->io->input['get']['alt']) && empty($this->io->input['post']['alt'])) {
			echo "
				<html>
				<head>
				<script type=\"text/javascript\">
				<!--
					alert('".$msg."');
					history.back();
				-->	
				</script>
				</head>
				</html>
			";
		} elseif (
			(!empty($this->io->input['get']['alt']) && $this->io->input['get']['alt'] == 'json')
			|| (!empty($this->io->input['post']['alt']) && $this->io->input['post']['alt'] == 'json')) {
			echo json_encode(array('res'=>0,'msg'=>$msg,'msgid'=>$msgid));
		}
		exit ; 

	}
	function jsConfirmMsg($question,$msgY,$msgN,$location_url){
		echo "
			<html>
			<head>
			<script type=\"text/javascript\">
			<!--
				var answer = confirm('".$question."')
				if(answer){
					alert('".$msgY."');
					windows.location = '".urldecode(base64_Decode($location_url))."' ; 
				}
				else{
					alert('".$msgN."');
					history.back();
				}
			-->	
			</script>
			</head>
			</html>
		";
		exit ; 
	}
}



class stringConvert{


	function strlen($str){
		
		return mb_strlen(utf8_decode($str)) ; 
	}


}



class intputOutput {
	public $input = array();
	function __construct() {
		if(isset($_POST)){	$this->input["post"]		=(ini_get('magic_quotes_gpc'))?$_POST	 :  $this->stripslashesArr($_POST)	;}
		if(isset($_GET)){	$this->input["get"]		=(ini_get('magic_quotes_gpc'))?$_GET	 :  $this->stripslashesArr($_GET) 	;}
		if(isset($_COOKIE)){	$this->input["cookie"] 		=(ini_get('magic_quotes_gpc'))?$_COOKIE :  $this->stripslashesArr($_COOKIE)	;}
		if(isset($_SESSION)){	$this->input["session"]		=(ini_get('magic_quotes_gpc'))?$_SESSION:  $this->stripslashesArr($_SESSION)	;}
		if(isset($_SERVER)){	$this->input["server"]		=(ini_get('magic_quotes_gpc'))?$_SERVER  :  $this->stripslashesArr($_SERVER)	;}
		if(isset($_FILES)){	$this->input["files"]		=(ini_get('magic_quotes_gpc'))?$_FILES  :  $this->stripslashesArr($_FILES)	;}
	}


	function stripslashesArr($var){
		$output = array();
		if(is_array($var)){
  			foreach ($var as $key => $value) {
				if(is_array($value)){

					foreach($value as $key2 => $value2){
						if(is_array($value2)){
							foreach($value2 as $key3 => $value3){
    								$output[$key][$key2][$key3] = addslashes($value3);
							}
						}
						else{
    							$output[$key][$key2] = addslashes($value2);
						}
					}
				}
				else{
    					$output[$key] = addslashes($value);
				}


			}
		}
		return $output;

	}


}

class patchControl {
	
        function getSourcesFile($input,$path_sources){
		if(isset($input["get"]["fun"])){
			if($input["get"]["fun"] != ""){
				if(isset($input["get"]["fun"])){
				        $path_sources .= "/".$input["get"]["fun"] ;
					
				}
			}
		}
		if(!isset($input["get"]["act"])){ 
			$input["get"]["act"] = "view" ; 
		}
	       	$path_sources .= "/".$input["get"]["act"].".php";
	       	$this->sourcesfile = $path_sources;


        }
	

        function getTplFile($input,$path_style,$default_template){

		//echo basename($path_style) ; exit ;
		$this->tplfile = $path_style."/".$default_template."/" ;
		
		if (isset($input["get"]["tpl"])) {
			if ($input["get"]["tpl"] != "") {
				$this->tplfile = $path_style."/".$input["get"]["tpl"]."/" ;
			}
		}
		if(isset($input["get"]["fun"])){
			if($input["get"]["fun"] != ""){
				$this->tplfile .= $input["get"]["fun"]."/" ;

			}
		}
		if(!isset($input["get"]["act"])){ 
			$input["get"]["act"] = "view" ; 
		}
		if(basename($path_style) == 'php'){
		  	$this->tplfile .= $input["get"]["act"].".php";
		}
		elseif(basename($path_style) == 'xsl'){
		  	$this->tplfile .= $input["get"]["act"].".xsl";
		}
		else{
			$this->tplfile .= $input["get"]["act"].".tpl";
		}

        }


	function getBlcokPath($tpl_name,$path_style,$default_template){
		$this->blockpath[$tpl_name] = $path_style."/".$default_template."/block/" ;
		if(basename($path_style) == 'php'){
			$this->blockpath[$tpl_name] .= $tpl_name.".php";
		}
		else{
			$this->blockpath[$tpl_name] .= $tpl_name.".tpl";
		}
	}


	function getImagePath($path_cdn, $template) {
		return $path_cdn . 'images/' . $template . '/';
	}


}

class config{

	function __construct() {
		global $config ; 
		$this->definedVar($config);
	}
	
        function definedVar($config){
		if(is_array($config)){
			foreach($config as $fk => $fv){
				$this->$fk = $fv ; 
			}
		}

        }



}

class Http{

        function setHeader($default_charset , $content_type = '' , $file_name = '' , $file_size = 0){
                if($content_type == 'xml'){
                        Header('Content-Type: text/xml; charset=UTF-8');
                        Header("Content-type : text/xml");
			// print FushionCharts BOM information to xml 
			echo pack ( "C3" , 0xef, 0xbb, 0xbf );
                }
                elseif($content_type == 'xmlfile'){
                        Header('Content-type: application/xml');
                        Header('Content-Disposition: attachment; filename="'.$file_name.'.xml"');
                }
                elseif($content_type == 'css'){
                        Header('Content-Type: text/css; charset=UTF-8');
                        Header("Content-type : text/css");
                }
                elseif($content_type == 'javascript'){
                        Header('Content-Type: text/javascript; charset=UTF-8');
                        Header("Content-type : text/javascript");
                }
                elseif($content_type == 'attachment'){
                        Header("Content-type: application/octet-stream");
                        Header("Accept-Ranges: bytes");
                        Header("Accept-Length: $file_size");
                        Header("Content-Disposition: attachment; filename=".$file_name);
                }
                else{
			
			Header("Expires: Mon , 26Jul 1997 05 : 00 : 00 GMT");
			Header("Last-Modified: ".gmdate("D,dMYH:i:s")."GMT");
			//header('Cache-control: private, must-revalidate'); 
			//Header("Transfer-Encoding: chunked");
                        Header('Content-Type: text/html; charset='.$default_charset);
			//ob_start('ob_gzhandler');
                }

        }
}





?>
