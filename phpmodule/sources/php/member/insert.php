<?php 
$this->loginChk();
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
$obj = array();
$obj['data'] = $this->io->input['post'];
unset($obj['data']['password']);
unset($obj['data']['password_2']);

$obj['back_url'] = $this->config->default_main.'/'.$this->io->input['get']['fun'].'/add?data='.base64_encode(urlEncode(json_encode($obj['data'])));

(empty($this->io->input["post"]['account']) || !isset($this->io->input["post"]['account']))? $this->ajaxRes('請輸入帳號',1,$obj) : $account = $this->io->input["post"]["account"];
(empty($this->io->input["post"]['password']) || !isset($this->io->input["post"]['password']))? $this->ajaxRes('請輸入密碼',1,$obj) : $password = $this->io->input["post"]["password"];
(empty($this->io->input["post"]['password_2']) || !isset($this->io->input["post"]['password_2']))? $this->ajaxRes('請輸入確認密碼',1,$obj) : $password_2 = $this->io->input["post"]["password_2"];
$password != $password_2 ? $this->ajaxRes('請確認兩次密碼是否一致',1,$obj) : '';
(empty($this->io->input["post"]['name']) || !isset($this->io->input["post"]['name']))? $this->ajaxRes('請輸入名稱',1,$obj) : $name = $this->io->input["post"]["name"];
(empty($this->io->input["post"]['role']) || !isset($this->io->input["post"]['role']))? $this->ajaxRes('請選擇存取權限',1,$obj) : $role = $this->io->input["post"]["role"];


// check account

$query = "
	SELECT
	*
	FROM
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_user
	WHERE
	prefixid = '".$this->config->db[0]["prefixid_index"]."'
	AND account = '".$account."'
	";
$check_account = $this->model->getQueryRecord($query);

if(!empty($check_account['table']['record'])){
	$this->ajaxRes('帳號重複，請重新輸入',1,$obj);
}



require_once $this->config->path_lib.'/convert/convertString.ini.php';
$this->str = new convertString();

$encode_password = $this->str->strEncode($password, $this->config->encode_key,$this->config->encode_iv);


// add new user
$query = "
INSERT INTO ".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_user
(
 `prefixid`,
 `uid`,
 `name`, 
 `account`,
 `password`, 
 `mobile`,
 `switch`,
 `insert_time`,
 `modifyt`
 )
VALUE
(
	'".$this->config->db[0]['prefixid_index']."',
	'',
	'".$name."',
	'".$account."',
	'".$encode_password."',
	'',
	'Y',
	NOW(),
	NOW()
 )
";
$this->model->query($query);

$uid = $this->model->mdb->insert_id;


// add user role
$query = "
INSERT INTO ".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_user_role_rt
(
 `prefixid`,
 `urrid`,
 `uid`, 
 `rid`, 
 `seq`,
 `switch`,
 `insert_time`,
 `modifyt`
 )
VALUE
(
	'".$this->config->db[0]['prefixid_index']."',
	'',
	'".$uid."',
	'".$role."',
	'0',
	'Y',
	NOW(),
	NOW()
 )
";
$this->model->query($query);



$this->ajaxRes('新增成功');