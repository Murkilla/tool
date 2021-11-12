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



###########################################
# Record Start
###########################################

$query ="
    SELECT
    *
    FROM
    ".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_fun
    WHERE
    prefixid = '".$this->config->db[0]['prefixid_index']."'
    AND fid = '".$this->io->input['get']['fid']."'
    AND switch = 'Y'
    ";
$table = $this->model->getQueryRecord($query);

###########################################
# Record End
###########################################


###########################################
# Rt Start
###########################################
###########################################
# Rt End
###########################################

$this->tplVar('table',$table["table"]);
$this->display();