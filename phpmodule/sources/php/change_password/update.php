<?php 
$this->loginChk();

$obj = array();
$obj['back_url'] = $this->io->input['post']['location_url'];

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

###########################################
# Input Data Checking Start
###########################################

(empty($this->io->input["post"]['uid']) || !isset($this->io->input["post"]["uid"])) ? $this->ajaxRes('資料有誤',0,$obj) : '';
empty($this->io->input["post"]["opass"]) ? $this->ajaxRes('請輸入舊密碼',1) : '';

if(empty($this->io->input["post"]["npass"])){
    $this->ajaxRes('請輸入新密碼',1);
}
if(empty($this->io->input["post"]["npass_2"])){
    $this->ajaxRes('請輸入確認密碼',1);
}
if($this->io->input["post"]["npass"] != $this->io->input["post"]["npass_2"]){
    $this->ajaxRes('請確認兩次密碼是否一致',1);
}

###########################################
# Input Data Checking End
###########################################


###########################################
# Update Data Start
###########################################

require_once $this->config->path_lib.'/convert/convertString.ini.php';
$this->str = new convertString();

// check old password
$encode_old_password = $this->str->strEncode($this->io->input["post"]["opass"], $this->config->encode_key,$this->config->encode_iv);
$query = "
    SELECT
    *
    FROM
    ".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_user
    WHERE
    prefixid = '".$this->config->db[0]['prefixid_index']."'
    AND uid = '".$this->io->input['post']['uid']."'
    AND switch = 'Y'
    ";
$check = $this->model->getQueryRecord($query);

if($check['table']['record'][0]['password'] != $encode_old_password){
    $this->ajaxRes('舊密碼輸入錯誤',1);
}

// update password
$encode_password = $this->str->strEncode($this->io->input["post"]["npass"], $this->config->encode_key,$this->config->encode_iv);
$query = "
    UPDATE
    ".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_user
    SET
    password = '".$encode_password."',
    modifyt = NOW()
    WHERE
    prefixid = '".$this->config->db[0]['prefixid_index']."'
    AND uid = '".$this->io->input["post"]["uid"]."'
    ";
$this->model->query($query);

###########################################
# Update Data End
###########################################


$obj['back_url'] = '/tool/logout';
$str = '，請重新登入';
session_destroy();
$this->ajaxRes('資料更新成功'.$str,0,$obj);