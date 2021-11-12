<?php
###########################################
# Setting MySql Connection Start
###########################################

require_once $this->config->path_mysql;
$this->model = new mysql();
$this->model->host = $this->config->db[0]['host'];
$this->model->user = $this->config->db[0]['username'];
$this->model->password = $this->config->db[0]['password'];
$this->model->dbName = $this->config->db[0]['db_name_0'];
$this->model->connect();

###########################################
# Setting MySql Connection End
###########################################


if(empty($this->io->input["post"]["account"])){
	$this->jsAlertMsg('帳號請勿空白',1);
}

if(empty($this->io->input["post"]["password"])){
	$this->jsAlertMsg('密碼請勿空白',1);
}

// check count
$query="
	SELECT 
	*
	FROM 
	".$this->config->db[0]["db_name_0"].".".$this->config->db[0]["prefixid_table"]."_user
	WHERE 
	prefixid = '".$this->config->db[0]["prefixid_index"]."' 
	AND account = '".$this->io->input["post"]["account"]."'
	AND switch = 'Y'
	";
$arr = $this->model->getQueryRecord($query);

if(empty($arr["table"]["record"][0])){
	//$this->jsAlertMsg('登入失敗,請填寫正確的帳號密碼!');
}


require_once $this->config->path_lib.'/convert/convertString.ini.php';
$this->str = new convertString();

$encrypt_password = $this->str->strEncode($this->io->input["post"]["password"], $this->config->encode_key,$this->config->encode_iv);
//var_dump($encrypt_password);exit;

if($encrypt_password != $arr['table']['record'][0]['password']){
	$this->jsAlertMsg('登入失敗,請填寫正確的帳號密碼!1');
}


// reset session
unset($_SESSION["user"]);
$_SESSION["user"] = $arr["table"]["record"][0] ; 


// get user role
$query ="
	SELECT 
	r.*
	FROM 
	".$this->config->db[0]["db_name_0"].".".$this->config->db[0]["prefixid_table"]."_user u
    LEFT OUTER JOIN
    ".$this->config->db[0]["db_name_0"].".".$this->config->db[0]["prefixid_table"]."_role_user_rt rur
    ON
    u.prefixid = rur.prefixid
    AND u.uid = rur.uid
    
    LEFT OUTER JOIN
    ".$this->config->db[0]["db_name_0"].".".$this->config->db[0]["prefixid_table"]."_role r
    ON
    rur.prefixid = r.prefixid
    AND rur.rid = r.rid
	WHERE 
	u.prefixid = '".$this->config->db[0]["prefixid_index"]."' 
    AND u.uid = '".$arr["table"]["record"][0]["uid"]."'
	";
$arr = $this->model->getQueryRecord($query);

$_SESSION["role"] = $arr["table"]["record"][0] ; 



header("location:".$this->config->default_main);
?>
