<?php

$this->loginChk();

if(!empty($this->io->input["get"]["data"])){
	$obj = json_decode( urldecode(base64_decode($this->io->input["get"]["data"])) );
	$this->tplVar('obj' , $obj) ;
}



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


$query = "
    SELECT
    *
    FROM
    ".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role
    WHERE
    prefixid = '".$this->config->db[0]['prefixid_index']."'
    AND switch = 'Y'
    ";
$table = $this->model->getQueryRecord($query);



$this->tplVar('table',$table["table"]);
$this->display();