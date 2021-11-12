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
        <link href="<?php echo $this->config->path_assets;?>/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->config->path_assets;?>/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->config->path_assets;?>/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->config->path_assets;?>/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->config->path_assets;?>/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css" />
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
                    <h3 class="page-title"> 使用者管理
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
                                <a href="<?php echo $this->config->default_main;?>/role">使用權限管理</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>修改資料</span>
                            </li>
                            
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN VALIDATION STATES-->
                            <div class="portlet light form-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject font-dark sbold uppercase">修改資料</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form data-act="<?php echo $this->config->default_main;?>/<?php echo $this->io->input["get"]["fun"];?>/update" enctype="multipart/form-data" id="form_sample_3" method="post" class="form-horizontal">
                                        <div class="form-body">
                                            <div class="alert alert-danger display-hide">
                                                <button class="close" data-close="alert"></button> 請修正下列錯誤！！！ </div>
                                            <div class="alert alert-success display-hide">
                                                <button class="close" data-close="alert"></button> 表單已成功完成！！! </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">
                                                    <span class="required"> * </span>
                                                    代號
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="rid"  class="form-control" value="<?php echo $this->tplVar['table']['record'][0]['rid'];?>" readonly/> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">
                                                    <span class="required"> * </span>
                                                    名稱
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="name" data-required="2" value="<?php echo $this->tplVar['table']['record'][0]['name'];?>" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">
                                                    描述
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="description" data-required="2" value="<?php echo $this->tplVar['table']['record'][0]['description'];?>" class="form-control" />
                                                </div>
                                            </div>
                                            <input type='hidden' name="rid" id="rid" value="<?php echo $this->tplVar["table"]["record"][0]["rid"];?>"/>
                                            <input type="hidden" name="location_url" id="location_url" value="<?php echo $this->config->default_main;?>/role"/>
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button id="btn-edit" type="button" data-url="<?php echo $this->config->default_main;?>/<?php echo $this->io->input["get"]["fun"];?>/update" class="btn green">確定</button>
                                                    <button type="button" class="btn default"><a href="<?php echo urldecode(base64_decode($this->tplVar["status"]['get']['location_url'])); ?>">取消</a></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END FORM-->
                                </div>
                                <!-- END VALIDATION STATES-->
                            </div>
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
        <script src="<?php echo $this->config->path_assets;?>/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/global/plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo $this->config->path_assets;?>/pages/scripts/form-validation.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->path_assets;?>/pages/scripts/ui-bootbox.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script src="<?php echo $this->config->path_js;?>/main.js" type="text/javascript"></script>

        <script>
            $(document).ready(function(){
                UIBootbox.init();  
            });

            $('#btn-edit').click(function(){
                dialogLoadPage($(this).data('url'),'系統訊息','edit'); 
            });
        </script>
    </body>

</html>