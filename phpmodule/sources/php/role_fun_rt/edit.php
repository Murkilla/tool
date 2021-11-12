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
	r.rid as rid , r.name as rname , rft.fid as fid, rft.view as tview
	FROM
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role_fun_rt rft 
	LEFT OUTER JOIN
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role r
	ON
	rft.prefixid = r.prefixid
	AND rft.rid = r.rid
	AND rft.switch = r.switch
	WHERE 
	rft.prefixid = '".$this->config->db[0]['prefixid_index']."'
	AND rft.rid = '".$this->io->input["get"]["rid"]."'
	AND rft.switch = 'Y'
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
	AND rid = '".$this->io->input["get"]["rid"]."'
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
		$table["table"]["record"][$v['rid']][$rv['fid']]['name'] = $rv["name"];
		$table["table"]["record"][$v['rid']][$rv['fid']]['tview'] = 'N';
		$table["table"]["record"][$v['rid']][$rv['fid']]['layer'] = $rv['layer'];
		$table["table"]["record"][$v['rid']][$rv['fid']]['node'] = $rv['node'];
		foreach($arr["table"]["record"] as $sk => $sv){
			if($sv['rid'] == $v['rid'] && $sv['fid'] == $rv['fid']){
				$table["table"]["record"][$v['rid']][$rv['fid']]['tview'] = $sv['tview'];
			}
		}
	}
}


###########################################
# Record End
###########################################


###########################################
# Rt Start
###########################################

$table["table"]['rt']['fun'] = $fun['table']["record"];

###########################################
# Rt End
###########################################

$this->tplVar('table',$table["table"]);
$this->display();