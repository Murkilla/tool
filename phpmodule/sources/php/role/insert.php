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

(empty($this->io->input["post"]['rid']) || !isset($this->io->input["post"]['rid']))? $this->ajaxRes('請輸入代號',1,$obj) : $rid = $this->io->input["post"]["rid"];
(empty($this->io->input["post"]['name']) || !isset($this->io->input["post"]['name']))? $this->ajaxRes('請輸入名稱',1,$obj) : $name = $this->io->input["post"]["name"];
(empty($this->io->input["post"]['description']) || !isset($this->io->input["post"]['description']))? '' : $description = $this->io->input["post"]["description"];
(empty($this->io->input["post"]['my_multi_select1']) || !isset($this->io->input["post"]['my_multi_select1']))? '' : $tmp_arr = $this->io->input["post"]["my_multi_select1"];


// check rid
$query = "
	SELECT
	*
	FROM
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role
	WHERE
	prefixid = '".$this->config->db[0]["prefixid_index"]."'
	AND rid = '".$rid."'
	";
$check_rid = $this->model->getQueryRecord($query);

if(!empty($check_rid['table']['record'])){
	$this->ajaxRes('代號重複，請重新輸入',1,$obj);
}

$check_node = ($layer == '2') ? $node : 0;


// add new role
$query = "
INSERT INTO ".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role
(
 `prefixid`,
 `rid`,
 `name`, 
 `description`,
 `seq`,
 `switch`,
 `insertt`,
 `modifyt`
 )
VALUE
(
	'".$this->config->db[0]['prefixid_index']."',
	'".$rid."',
	'".$name."',
	'".$description."',
	'0',
	'Y',
	NOW(),
	NOW()
 )
";
$this->model->query($query);


// create new role and all fun's relationship (tview = N)
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
	'".$rid."',
	fid,
	'N',
	'N',
	'N',
	'N',
	'0',
	'Y',
	NOW(),
	NOW()
	FROM
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_fun
	WHERE
	prefixid = '".$this->config->db[0]['prefixid_index']."'
	";
$this->model->query($query);

// update selected fid's tview to Y
$update_query = '';
for($i=0 ; $i < count($tmp_arr) ; $i++){
	if(strlen($update_query) > 0){
		$update_query .= ' || ';
	}
	if(strlen($update_query) < 1){
		$update_query .= 'AND (';
	}
	$update_query .= "fid= '".$tmp_arr[$i]."'";
}
$update_query .= ")";

$query = "
	UPDATE
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role_fun_rt
	SET
	view = 'Y',
	modifyt = NOW()
	WHERE
	prefixid = '".$this->config->db[0]['prefixid_index']."'
	AND rid = '".$rid."'
	";
$query .= $update_query;
$this->model->query($query);

$this->ajaxRes('新增成功');