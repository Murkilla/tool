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


$obj['back_url'] = $this->config->default_main.'/'.$this->io->input['get']['fun'].'/add?data='.base64_encode(urlEncode(json_encode($obj['data'])));

(empty($this->io->input["post"]['fid']) || !isset($this->io->input["post"]['fid']))? $this->ajaxRes('請輸入代號',1,$obj) : $fid = $this->io->input["post"]["fid"];
(empty($this->io->input["post"]['name']) || !isset($this->io->input["post"]['name']))? $this->ajaxRes('請輸入名稱',1,$obj) : $name = $this->io->input["post"]["name"];
(empty($this->io->input["post"]['description']) || !isset($this->io->input["post"]['description']))? '' : $description = $this->io->input["post"]["description"];
(empty($this->io->input["post"]['node']) || !isset($this->io->input["post"]['node']))? $this->ajaxRes('請選擇父層節點',1,$obj) : $node = $this->io->input["post"]["node"];
(!isset($this->io->input["post"]['layer']))? $this->ajaxRes('請選擇層級',1,$obj) : $layer = $this->io->input["post"]["layer"];


// check fid

$query = "
	SELECT
	*
	FROM
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_fun
	WHERE
	prefixid = '".$this->config->db[0]["prefixid_index"]."'
	AND fid = '".$fid."'
	";
$check_fid = $this->model->getQueryRecord($query);

if(!empty($check_fid['table']['record'])){
	$this->ajaxRes('代號重複，請重新輸入',1,$obj);
}

$check_node = ($layer == '2') ? $node : 0;

// get new seq
$query = "
	SELECT
	MAX(seq) as seq
	FROM
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_fun
	WHERE
	prefixid = '".$this->config->db[0]["prefixid_index"]."'
	AND node = '".$check_node."'
	";
$check_seq = $this->model->getQueryRecord($query);

$new_seq = $layer == '2' ? $check_seq['table']['record'][0]['seq'] + 1 : $check_seq['table']['record'][0]['seq'] + 10;

// add new fun
$query = "
INSERT INTO ".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_fun
(
 `prefixid`,
 `fid`,
 `name`, 
 `description`,
 `node`, 
 `layer`,
 `seq`,
 `switch`,
 `insertt`,
 `modifyt`
 )
VALUE
(
	'".$this->config->db[0]['prefixid_index']."',
	'".$fid."',
	'".$name."',
	'".$description."',
	'".$check_node."',
	'".$layer."',
	'".$new_seq."',
	'Y',
	NOW(),
	NOW()
 )
";
$this->model->query($query);


// create new fun and all role's relationship (tview = N)
$query = "
	INSERT INTO 
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role_fun_rt
	(
	`prefixid`,
	`rid`,
	`fid`,
	`view`, 
	`add`,
	`edit`, 
	`delete`,
	`seq`,
	`switch`,
	`insertt`,
	`modifyt`
	)
	SELECT
	'".$this->config->db[0]["prefixid_index"]."',
	rid,
	'".$fid."',
	'N',
	'N',
	'N',
	'N',
	'0',
	'Y',
	NOW(),
	NOW()
	FROM
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role
	WHERE
	prefixid = '".$this->config->db[0]['prefixid_index']."'
	";
$this->model->query($query);

$this->ajaxRes('新增成功');