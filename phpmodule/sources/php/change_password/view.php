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
# Status Start 
###########################################

$status["status"]["path"] = $this->config->default_main;

if($this->io->input["get"]["fun"] != ''){
	$status["status"]["path"] .= "/".$this->io->input["get"]["fun"] ;
}

if($this->io->input["get"]["act"] != '' && $this->io->input["get"]["act"] != 'view'){
	$status["status"]["path"] .= "/".$this->io->input["get"]["act"] ;
}

$status["status"]["path"] .= "/"; 

############################################
# Status End 
############################################

$this->tplVar('status' , $status['status']);
$this->display();