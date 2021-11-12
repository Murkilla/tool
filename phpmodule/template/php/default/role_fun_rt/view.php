<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
    <head>
       
        <?php require_once $this->config->path_head;?>

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo $this->config->path_assets;?>/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->config->path_assets;?>/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
    </head>
 <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
        <!-- BEGIN HEADER -->
        <?php require_once $this->config->path_header;?>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <?php require_once $this->config->path_left;?>
                    <!-- END SIDEBAR MENU -->
                </div>
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">  存取權限管理
                        <small></small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-settings"></i>
                                <span>管理</span>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="<?php echo $this->config->default_main;?>/role_fun_rt">存取權限管理</a>
                            </li>
                            
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="tools"> </div>
                                </div>
                                <div class="portlet-body">
                                <div class="table-toolbar">
                                        <div class="row">
                                        </div>
                                </div>
                                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th>身份</th>
                                                <?php foreach($this->tplVar["table"]['rt']['fun'] as $k => $v):?>
                                                    <?php if($v['node'] == '0' && $v['layer'] == '1'):?>
                                                        <th style='background-color: #FFEE99;'><?php echo $v['name'];?></th>
                                                    <?php endif;?>
                                                    <?php foreach($this->tplVar['table']['rt']['fun'] as $rk => $rv):?>
                                                        <?php if($v['fid'] == $rv['node'] && $rv['layer'] == '2'):?>
                                                            <th><?php echo $rv['name'];?></th>
                                                        <?php endif;?>
                                                    <?php endforeach;?>
                                                <?php endforeach;?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(is_array($this->tplVar["table"]["record"]) && !empty($this->tplVar["table"]["record"])):?>
                                                
                                                <?php foreach($this->tplVar["table"]["record"] as $rk => $rv):?>
                                                    <tr>
                                                        <td><a href="<?php echo $this->config->default_main;?>/<?php echo $this->io->input['get']['fun'];?>/edit?rid=<?php echo $rv['rid'];?>&location_url=<?php echo base64_encode(urlencode($this->tplVar['status']['base_href']));?>"><?php echo $rv["rname"];?></a></td>
                                                        <?php foreach($rv[0] as $tk => $tv):?>
                                                            <?php if($tv['node'] == '0' && $tv['layer'] == '1'):?>
                                                                <td style="text-align:center; font-size:20px; <?php echo $tv['tview']=='N' ? 'color: red;':'';?>">
                                                                    <?php if($tv['tview'] == 'Y'):?>
                                                                        <i class="fa fa-check"></i>
                                                                    <?php else:?>
                                                                        <i class="fa fa-times"></i>
                                                                    <?php endif;?>
                                                                </td>
                                                            <?php endif;?>
                                                            <?php foreach($rv[0] as $sk => $sv):?>
                                                                <?php if($tk == $sv['node'] && $sv['layer'] == '2'):?>
                                                                    <td style="text-align:center; font-size:20px; <?php echo $sv['tview']=='N' ? 'color: red;':'';?>">
                                                                        <?php if($sv['tview'] == 'Y'):?>
                                                                            <i class="fa fa-check"></i>
                                                                        <?php else:?>
                                                                            <i class="fa fa-times"></i>
                                                                        <?php endif;?>
                                                                    </td>
                                                                <?php endif;?>
                                                            <?php endforeach;?>
                                                        <?php endforeach;?>
                                                    </tr>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                    <div id="dialog-content" style="display:none;"></div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php require_once $this->config->path_footer;?>
        <!-- END FOOTER -->
        <!--[if lt IE 9]>
            <script src="<?php echo $this->config->path_assets;?>/global/plugins/respond.min.js"></script>
            <script src="<?php echo $this->config->path_assets;?>/global/plugins/excanvas.min.js"></script> 
        <![endif]-->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo $this->config->path_assets;?>/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo $this->config->path_assets;?>/pages/scripts/table-datatables-buttons.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/pages/scripts/ui-bootbox.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script src="<?php echo $this->config->path_js;?>/main.js" type="text/javascript"></script>
        <script>
            $(document).ready(function(){
                UIBootbox.init();
                $('.dt-buttons').remove();  
            });

            $('#btn-add').click(function(){
                dialogLoadPage($(this).data('url'),'新增使用者','add'); 
            });
        </script>
    </body>

</html>