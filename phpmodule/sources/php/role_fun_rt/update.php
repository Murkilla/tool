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

(empty($this->io->input["post"]['rid']) || !isset($this->io->input["post"]["rid"])) ? $this->ajaxRes('資料有誤',0,$obj) : '';


###########################################
# Input Data Checking End
###########################################



###########################################
# Update Data Start
###########################################

// turn ALL fid to N
    $query = "
        UPDATE
        ".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role_fun_rt
        SET
        view = 'N',
        modifyt = NOW()
        WHERE
        prefixid = '".$this->config->db[0]["prefixid_index"]."'
        AND rid = '".$this->io->input["post"]["rid"]."'
        ";
    $this->model->query($query);

$where_query = '';
if(isset($this->io->input["post"]["fun"])){
    foreach($this->io->input["post"]["fun"] as $k => $v){
        
        if(strlen($where_query) > 0){
            $where_query .= ' || ';
        }
        if(strlen($where_query) < 1){
            $where_query .= '(';
        }
        $where_query .= "fid = '".$k."'";
    }
    $where_query .= ")";


    // turn selected fid to Y
    $query = "
        UPDATE
        ".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role_fun_rt
        SET
        view = 'Y',
        modifyt = NOW()
        WHERE
        prefixid = '".$this->config->db[0]["prefixid_index"]."'
        AND rid = '".$this->io->input["post"]["rid"]."'
        AND ".$where_query."
        ";
    $this->model->query($query);
}


if($this->io->input["session"]["user"]["rid"] == $this->io->input["post"]["rid"]){
        $obj['back_url'] = '/tool/logout';
        $str = '，請重新登入';
}

###########################################
# Update Data End
###########################################



$this->ajaxRes('資料更新成功'.$str,0,$obj);