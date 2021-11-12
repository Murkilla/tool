<div class="row">
    <div class="col-md-12">
        <div class="portlet light form-fit ">
            <div class="portlet-body form" >
                <form id="add-form" class="form-horizontal " role="form" method="post" enctype="multipart/form-data" data-act="<?php echo $this->config->default_main; ?>/<?php echo $this->io->input['get']['fun']; ?>/insert">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> 請修正下列錯誤！！！ 
                        </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> 表單已成功完成！！! 
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                <span class="required"> * </span>
                                代號：
                            </label>
                            <div class="col-md-9">
                                <input id="rid" name="rid" type="text" class="form-control" placeholder="請填入代號" value="<?php if(isset($this->tplVar["obj"])){echo $this->tplVar["obj"]->rid;}?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                <span class="required"> * </span>
                                名稱：
                            </label>
                            <div class="col-md-9">
                                <input id="name" name="name" type="text" class="form-control" placeholder="請填入名稱" value="<?php if(isset($this->tplVar["obj"])){echo $this->tplVar["obj"]->name;}?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                <span class="required"> * </span>
                                描述：
                            </label>
                            <div class="col-md-9">
                                <input id="description" name="description" type="text" class="form-control" placeholder="請填入描述" value="<?php if(isset($this->tplVar["obj"])){echo $this->tplVar["obj"]->description;}?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">
                                <span class="required"> * </span>
                                功能：
                            </label>
                            
                            <div class="col-md-9">
                                <select multiple="multiple" class="multi-select" id="my_multi_select1" name="my_multi_select1[]">
                                    <?php if(!empty($this->tplVar["table"]['rt']['fun_layer1'])):?>
                                        <?php foreach($this->tplVar["table"]['rt']['fun_layer1'] as $k => $v):?>
                                            <option value="<?php echo $v['fid'];?>" style='background-color: #FFEE99;'
                                                <?php 
                                                    if(isset($this->tplVar["obj"])){
                                                        for($i=0 ; $i < count($this->tplVar['obj']->my_multi_select1) ; $i++){
                                                            if($v['fid'] == $this->tplVar['obj']->my_multi_select1[$i]){
                                                                echo 'selected';
                                                                break;
                                                            }
                                                        }
                                                    }
                                                ?>    
                                            ><?php echo $v['name'];?></option>
                                            <?php foreach($this->tplVar["table"]['rt']['fun_layer2'] as $rk => $rv):?>
                                                <?php if($rv['node'] == $v['fid']):?>
                                                    <option value="<?php echo $rv['fid'];?>"
                                                        <?php 
                                                            if(isset($this->tplVar["obj"])){
                                                                for($i=0 ; $i < count($this->tplVar['obj']->my_multi_select1) ; $i++){
                                                                    if($rv['fid'] == $this->tplVar['obj']->my_multi_select1[$i]){
                                                                        echo 'selected';
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                        ?>    
                                                    ><?php echo $rv['name'];?></option>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $this->config->path_assets;?>/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->path_assets;?>/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
<script src="<?php echo $this->config->path_assets;?>/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->path_assets;?>/pages/scripts/components-multi-select.min.js" type="text/javascript"></script>