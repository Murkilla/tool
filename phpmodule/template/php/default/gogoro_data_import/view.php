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
		<link href="<?php echo $this->config->path_assets;?>/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->config->path_assets;?>/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <style type="text/css">
            hr.style-three {
                border: 0;
                border-bottom: 1px dashed #ccc;
                background: black;
            }
        </style>
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
        <div class="page-container" style="margin-top:68px;">
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
                    <h3 class="page-title"> gogoro????????????????????????
                        <small></small>
                    </h3>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <span>????????????</span>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="<?php echo $this->config->default_main;?>/gogoro_data_import">gogoro????????????????????????</a>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light ">
                                <div class="portlet-body">
                                    <div class="caption font-dark">
                                        <form id="form_sample_3" action="<?php echo $this->config->default_main;?>/<?php echo $this->io->input['get']['fun'];?>/import" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
                                            <div class="form-group">
                                                <div class="clearfix">
                                                    <div class="btn-group " data-toggle="buttons">
                                                        <label class="btn btn-default">
                                                            <input type="radio" class="toggle" name='type' value ='main' id ='main'> ?????? </label>
                                                        <label class="btn btn-default">
                                                            <input type="radio" class="toggle" name='type' value ='main_only' id ='main_only'> ??????_???????????? </label>
                                                        <label class="btn btn-default">
                                                            <input type="radio" class="toggle" name='type' value ='sub' id ='sub'> ?????? </label>
                                                        <label class="btn btn-default">
                                                            <input type="radio" class="toggle" name='type' value ='sub_only' id ='sub_only'> ??????_???????????? </label>
                                                    </div>
                                                    <div class="dateArea input-group input-medium date date-picker hidden" data-date-format="yyyy/mm/dd" data-date="<?php echo date('Y/m/d');?>" >
                                                        <input type="text" class="form-control" id="startdate" name="startdate" placeholder="????????????" readonly>
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <div class="dateArea input-group input-medium date date-picker hidden" data-date-format="yyyy/mm/dd" data-date="<?php echo date('Y/m/d');?>" >
                                                        <input type="text" class="form-control" id="enddate" name="enddate" placeholder="????????????" readonly>
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <!-- /input-group -->
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <label class="control-label"></label> &nbsp;&nbsp;
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span class="btn green btn-file">
                                                            <span class="fileinput-new"> ???????????? </span>
                                                            <span class="fileinput-exists"> ?????? </span>
                                                            <input type="file" id="upload" name="files"/> 
                                                        </span>
                                                        <span class="fileinput-filename"> </span> &nbsp;
                                                        <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                                    </div>
                                                    <button id="action" type="button" class="btn green" data-url="<?php echo $this->config->default_main;?>/<?php echo $this->io->input['get']['fun'];?>/import">
                                                        <i class="fa fa-check"></i>??????
                                                    </button>
                                            </div>
                                            <div class="form-actions">
                                            </div>
                                        </form>
                                        <hr class="style-three">
                                        <form id="form2" action="<?php echo $this->config->default_main;?>/<?php echo $this->io->input['get']['fun'];?>/import" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
                                            <div class="form-group" >
                                                <label class="control-label"></label> &nbsp;&nbsp;
                                                    <button id="send" type="button" class="btn red" data-url="<?php echo $this->config->default_main;?>/<?php echo $this->io->input['get']['fun'];?>/import">
                                                        <i class="fa fa-times"></i>??????????????????????????????????????????  
                                                    </button>
                                                    <input type="hidden" name="clear" id="clear" value="clear"/>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
                <div id="dialog-content" style="display:none;"></div>
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
		<script src="<?php echo $this->config->path_assets;?>/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo $this->config->path_assets;?>/pages/scripts/table-datatables-buttons.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/pages/scripts/ui-bootbox.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script src="<?php echo $this->config->path_js;?>/main.js" type="text/javascript"></script>
        <script>
            $(document).ready(function(){
                UIBootbox.init();  
            });

            $('input[name="type"]').on('change',function(){
                if($('input[name="type"]:checked').val() == 'sub_only'){
                $('.dateArea').removeClass("hidden");
                }else{
                $('.dateArea').addClass("hidden");
                }
            });
            $('#action').on('click',function(){
                var form = $('#form_sample_3')[0];
                var formData = new FormData(form);
                $.ajax({  
                url: $(this).data("url"),
                dataType:"json",
                data: formData,
                type:'POST',
                async:true,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend:function(){
                    App.blockUI();
                },
                success:function(output){
                    App.unblockUI();
                    console.log(output.log);
                    showConfirm('????????????',output.msg,1);
                },  
                error: function(err){
                    App.unblockUI();
                    console.log(err.responseText);
                    showConfirm('????????????',err.responseText,1);
                }   
                });
            });
            $('#send').on('click',function(){
                showConfirm('????????????',"??????????????????????",2,function(){
                    var form = $('#form2')[0];
                    var formData = new FormData(form);
                    $.ajax({  
                        url: $('#send').data("url"),
                        dataType:"json",
                        data: formData,
                        type:'POST',
                        async:true,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend:function(){
                                App.blockUI();
                        },
                        success:function(output){
                                App.unblockUI();
                                console.log(output.log);
                                showConfirm('????????????',output.msg,1);
                                //alert(output.msg);
                        },  
                        error: function(err){
                                App.unblockUI();
                                console.log(err.responseText);
                                showConfirm('????????????',err.responseText,1);
                        }   
                    });
                });
            });

            // $('#btn-add').click(function(){
            //     dialogLoadPage($(this).data('url'),'??????','add'); 
            // });
            // $('#btn-edit').click(function(){
            //     dialogLoadPage($(this).data('url'),'??????','edit'); 
            // });
        </script>
    </body>

</html>
