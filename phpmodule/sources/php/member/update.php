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
empty($this->io->input["post"]["account"]) ? $this->ajaxRes('資料有誤',0,$obj) : '';
empty($this->io->input["post"]["name"]) ? $this->ajaxRes('名稱請勿空白',1) : '';
empty($this->io->input["post"]["role"]) ? $this->ajaxRes('請選擇存取權限',1) : '';

$check = false;
$str = '';
if(!empty($this->io->input['post']["password"]) || !empty($this->io->input["post"]["password_2"])){
    if(empty($this->io->input["post"]["password"])){
        $this->ajaxRes('請輸入新密碼',1);
    }
    if(empty($this->io->input["post"]["password_2"])){
        $this->ajaxRes('請輸入新密碼確認',1);
    }
    if($this->io->input["post"]["password"] != $this->io->input["post"]["password_2"]){
        $this->ajaxRes('請確認兩次密碼是否一致',1);
    }

    $check = true;
}

###########################################
# Input Data Checking End
###########################################


###########################################
# Update Data Start
###########################################

// update user info
$query = "
    UPDATE 
    ".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_user
    SET
    name = '".$this->io->input["post"]["name"]."',
    modifyt = NOW()
    WHERE
    prefixid = '".$this->config->db[0]["prefixid_index"]."'
    AND uid = '".$this->io->input["post"]["uid"]."'
    AND account = '".$this->io->input["post"]["account"]."'
    ";
$this->model->query($query);

// update user's role
$query = "
    UPDATE 
    ".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role_user_rt
    SET
    rid = '".$this->io->input["post"]["role"]."',
    modifyt = NOW()
    WHERE
    prefixid = '".$this->config->db[0]["prefixid_index"]."'
    AND uid = '".$this->io->input["post"]["uid"]."'
    ";
$this->model->query($query);

// update password if it's change
if($check){
    require_once $this->config->path_lib.'/convert/convertString.ini.php';
    $this->str = new convertString();
    $encode_password = $this->str->strEncode($this->io->input["post"]["password"], $this->config->encode_key,$this->config->encode_iv);

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
    if($this->io->input["session"]["user"]["uid"] == $this->io->input["post"]["uid"]){
        $obj['back_url'] = '/tool/logout';
        $str = '，請重新登入';
        session_destroy();
    }
}

###########################################
# Update Data End
###########################################


$this->ajaxRes('資料更新成功'.$str,0,$obj);