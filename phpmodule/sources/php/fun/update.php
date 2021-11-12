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

(empty($this->io->input["post"]['fid']) || !isset($this->io->input["post"]["fid"])) ? $this->ajaxRes('資料有誤',0,$obj) : '';
empty($this->io->input["post"]["name"]) ? $this->ajaxRes('名稱請勿空白',1) : '';

###########################################
# Input Data Checking End
###########################################


###########################################
# Update Data Start
###########################################

// update fun's info
$query = "
    UPDATE 
    ".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_fun
    SET
    name = '".$this->io->input["post"]["name"]."',
    description = '".$this->io->input["post"]["description"]."',
    modifyt = NOW()
    WHERE
    prefixid = '".$this->config->db[0]["prefixid_index"]."'
    AND fid = '".$this->io->input["post"]["fid"]."'
    ";
$this->model->query($query);

###########################################
# Update Data End
###########################################



$this->ajaxRes('資料更新成功'.$str,0,$obj);