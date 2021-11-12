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
    u.* , rur.rid
    FROM
    ".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_user u
    LEFT OUTER JOIN
    ".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role_user_rt rur
    ON
    u.prefixid = rur.prefixid
    AND u.uid = rur.uid
    WHERE
    u.prefixid = '".$this->config->db[0]['prefixid_index']."'
    AND u.uid = '".$this->io->input['get']['uid']."'
    AND u.switch = 'Y'
    ";
$table = $this->model->getQueryRecord($query);



###########################################
# Record End
###########################################


###########################################
# Rt Start
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
$role = $this->model->getQueryRecord($query);
$table["table"]["rt"]["role"] = $role["table"]["record"];

###########################################
# Rt End
###########################################

$this->tplVar('table',$table["table"]);

$this->display();