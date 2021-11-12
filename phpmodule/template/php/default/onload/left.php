<?php 

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

$fun_layer_1["table"]["record"] = $fun_layer_2["table"]['record'] = array();


$query ="
	SELECT 
	f.* ,rfr.view as view
	FROM 
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_fun f
	LEFT OUTER JOIN
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role_fun_rt rfr
	ON
	f.prefixid = rfr.prefixid
	AND f.fid = rfr.fid
	AND rfr.rid = '".$this->io->input["session"]["role"]["rid"]."'
	WHERE 
	f.prefixid = '".$this->config->db[0]['prefixid_index']."'
	AND f.layer = '1'
	ORDER BY f.seq ASC
	";  

$fun_layer_1 = $this->model->getQueryRecord($query); 

$query ="
	SELECT 
	f.* ,rfr.view as view
	FROM 
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_fun f
	LEFT OUTER JOIN
	".$this->config->db[0]['db_name_0'].".".$this->config->db[0]['prefixid_table']."_role_fun_rt rfr
	ON
	f.prefixid = rfr.prefixid
	AND f.fid = rfr.fid
	AND rfr.rid = '".$this->io->input["session"]["role"]["rid"]."'
	WHERE 
	f.prefixid = '".$this->config->db[0]['prefixid_index']."'
	AND f.layer = '2'
	ORDER BY f.seq ASC
	";  

$fun_layer_2 = $this->model->getQueryRecord($query);
$fun = isset($this->tplVar['status']['get']['fun']) ? $this->tplVar["status"]["get"]["fun"] : '';
$act = $this->tplVar['status']['get']['act'];
?>



<ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
	<?php if(!empty($fun_layer_1["table"]["record"])):?>
		<?php foreach($fun_layer_1['table']['record'] as $rk => $rv):?>
			<?php if($rv['view'] == 'Y'):?>
				<li class="nav-item 
					<?php 
						if(!empty($fun_layer_2['table']['record'])){
							foreach($fun_layer_2['table']['record'] as $sk => $sv){
								if($sv['node'] == $rv["fid"]){
									if($fun == $sv["fid"]){
										echo "start active open";
									}
								}
							} 
						}

					?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<?php if($rv["fid"] == 'manager'):?>
							<i class="icon-settings"></i>
						<?php else:?>
							<i class="icon-home"></i>
						<?php endif;?>
						<span class="title"><?php echo $rv["name"];?></span>
						<?php if(!empty($fun_layer_2['table']['record'])):?>
							<?php foreach($fun_layer_2['table']['record'] as $sk => $sv):?>
								<?php if($fun == $sv["fid"]):?>
								<span class="selected"></span>
								<span class="arrow open"></span>
								<?php else:?>
								<span class="arrow"></span>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
					</a>
					<ul class="sub-menu">
						<?php if(!empty($fun_layer_2['table']['record'])):?>
							<?php foreach($fun_layer_2['table']['record'] as $sk => $sv):?>
								<?php if($sv['node'] == $rv["fid"] && $sv["view"] == 'Y'):?>
									<li class="nav-item <?php echo ($sv["fid"] == $fun) ? 'start active open' : '';?>">
										<a href="<?php echo $this->config->default_main;?>/<?php echo $sv["fid"];?>" class="nav-link ">
											<i class="icon-bar-chart"></i>
											<span class="title"><?php echo $sv["name"];?></span>
											<?php if($fun == $sv["fid"] && $act == 'view'):?>
											<span class="selected"></span>
											<?php endif;?>
										</a>
									</li>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
					</ul>
				</li> 
			<?php endif;?>
		<?php endforeach;?>
	<?php endif;?>
</ul>
