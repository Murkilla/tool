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
                    <h3 class="page-title"> 功能管理
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
                                <a href="<?php echo $this->config->default_main;?>/fun">功能管理</a>
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
                                            <div class="col-md-6">
                                                <div class="btn-group">
                                                    <button id="btn-add" class="btn green" data-url="<?php echo $this->config->default_main;?>/<?php echo $this->io->input['get']['fun'];?>/add"> <i class="fa fa-plus"></i> 新增</button>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th> 代號 </th>
                                                <th> 名稱 </th>
                                                <th> 描述 </th>
                                                <th> 父層節點 </th>
                                                <th> 層級 </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(is_array($this->tplVar["table"]) && !empty($this->tplVar["table"])):?>
                                                <?php foreach($this->tplVar["table"]["record"] as $k => $v):?>
                                                    <tr style='background-color: #FFEE99;'>
                                                        <td><?php echo $v["fid"];?></td>
                                                        <td ><a href="<?php echo $this->config->default_main;?>/<?php echo $this->io->input["get"]["fun"];?>/edit?fid=<?php echo $v['fid'];?>&location_url=<?php echo base64_encode(urlencode($this->tplVar['status']['base_href']));?>"><?php echo $v["name"];?></a></td>
                                                        <td><?php echo $v["description"];?></td>
                                                        <td><?php echo $v["node"];?></td>
                                                        <td><?php echo $v["layer"];?></td>
                                                    </tr>
                                                    <?php if(is_array($this->tplVar['table']['rt']['layer2']) && !empty($this->tplVar['table']['rt']['layer2'])):?>
                                                        <?php foreach($this->tplVar['table']['rt']['layer2'] as $rk => $rv):?>
                                                            <?php if($rv['node'] == $v['fid']):?>
                                                                <tr>
                                                                    <td><?php echo $rv["fid"];?></td>
                                                                    <td><a href="<?php echo $this->config->default_main;?>/<?php echo $this->io->input["get"]["fun"];?>/edit?fid=<?php echo $rv['fid'];?>&location_url=<?php echo base64_encode(urlencode($this->tplVar['status']['base_href']));?>"><?php echo $rv["name"];?></a></td>
                                                                    <td><?php echo $rv["description"];?></td>
                                                                    <td><?php echo $rv["node"];?></td>
                                                                    <td><?php echo $rv["layer"];?></td>
                                                                </tr>
                                                            <?php endif;?>
                                                        <?php endforeach;?>
                                                    <?php endif;?>
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
            });

            $('#btn-add').click(function(){
                dialogLoadPage($(this).data('url'),'新增功能','add'); 
            });
        </script>
    </body>

</html>