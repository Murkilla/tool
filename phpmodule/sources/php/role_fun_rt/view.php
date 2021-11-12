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


$query ="
	SELECT 
	r.rid as rid , r.name as rname , rft.fid as fid, rft.view as tview
	FROM 
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role r
	LEFT OUTER JOIN
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role_fun_rt rft
	ON
	r.prefixid = rft.prefixid
	AND r.rid = rft.rid
	AND r.switch = rft.switch
	
	WHERE 
	r.prefixid = '".$this->config->db[0]['prefixid_index']."'
	AND r.switch = 'Y'
	";  
//echo $query ; exit ;

// Table Record End

$arr = $this->model->getQueryRecord($query); 

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


$query = "
	SELECT
	*
	FROM
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_fun
	WHERE
	prefixid = '".$this->config->db[0]['prefixid_index']."'
	AND switch = 'Y'
	ORDER BY seq ASC
	";
$fun = $this->model->getQueryRecord($query);



$tmp_arr = array();
$table["table"]["record"] = array();

foreach($role["table"]["record"] as $k => $v){
	$table["table"]["record"][$v['rid']] = array();
	$table["table"]["record"][$v['rid']]['rid'] = $v['rid'];
	$table["table"]["record"][$v['rid']]['rname'] = $v['name'];
	foreach($fun['table']['record'] as $rk => $rv){
		$table["table"]["record"][$v['rid']][0][$rv['fid']]['tview'] = 'N';
		$table["table"]["record"][$v['rid']][0][$rv['fid']]['layer'] = $rv['layer'];
		$table["table"]["record"][$v['rid']][0][$rv['fid']]['node'] = $rv['node'];
		foreach($arr["table"]["record"] as $sk => $sv){
			if($sv['rid'] == $v['rid'] && $sv['fid'] == $rv['fid']){
				$table["table"]["record"][$v['rid']][0][$rv['fid']]['tview'] = $sv['tview'];
			}
		}
	}
}
$table["table"]['rt']['fun'] = $fun['table']["record"];

$this->tplVar('table',$table["table"]);
$this->tplVar('status' , $status['status']);
$this->display();