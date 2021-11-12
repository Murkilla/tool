<div class="portlet-body form" >
    <form id="add-form" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" data-act="<?php echo $this->config->default_main; ?>/<?php echo $this->io->input['get']['fun']; ?>/insert">
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
                    <input id="fid" name="fid" type="text" class="form-control" placeholder="請填入代號" value="<?php if(isset($this->tplVar["obj"])){echo $this->tplVar["obj"]->fid;}?>"/>
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
                <label class="col-md-3 control-label">
                    <span class="required"> * </span>
                    父層節點：
                </label>
                <div class="col-md-9">
                    <select class="form-control" id="node" name="node">
                        <option value="">請選擇</option>
                        <option value="1" <?php if(isset($this->tplVar["obj"]) && $this->tplVar['obj']->node == '1'){echo 'selected';}?> >此為第一層</option>
                        <?php if(is_array($this->tplVar["table"]["rt"]) && !empty($this->tplVar["table"]["rt"])):?>
                            <?php foreach($this->tplVar["table"]["rt"]["fun"] as $rk => $rv):?>
                                    <option value="<?php echo $rv["fid"];?>" <?php if(isset($this->tplVar["obj"]) && $this->tplVar['obj']->node == $rv['fid']){echo 'selected';}?> ><?php echo $rv["name"];?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">
                    <span class="required"> * </span>
                    層級：
                </label>
                <div class="col-md-9">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default">
                            <input id="layer_1" name="layer" type="radio" class="toggle" value="1"> 第一層 
                        </label>
                        <label class="btn btn-default">
                            <input id="layer_2" name="layer" type="radio" class="toggle" value="2"> 第二層 
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $('#node').on('change',function(){
        var value = $(this)[0].selectedOptions[0].value;
        if(value == 1){
            $('#layer_2').parent().addClass('disabled');
		    $('#layer_1').parent().removeClass('disabled');
            $('#layer_1').parent().addClass('active');
            $('#layer_1').prop("checked",true);
        }else if(value == ""){
            $('#layer_1').parent().addClass('disabled');
		    $('#layer_2').parent().addClass('disabled');
        }else{
            $('#layer_1').parent().addClass('disabled');
		    $('#layer_2').parent().removeClass('disabled');
            $('#layer_2').parent().addClass('active');
            $('#layer_2').prop("checked",true);
        }
    });

    $('body').ready(function(){
        var value = $('#node').val();
        if(value == 1){
            $('#layer_2').parent().addClass('disabled');
		    $('#layer_1').parent().removeClass('disabled');
            $('#layer_1').parent().addClass('active');
            $('#layer_1').prop("checked",true);
        }else if(value == ""){
            $('#layer_1').parent().addClass('disabled');
		    $('#layer_2').parent().addClass('disabled');
        }else{
            $('#layer_1').parent().addClass('disabled');
		    $('#layer_2').parent().removeClass('disabled');
            $('#layer_2').parent().addClass('active');
            $('#layer_2').prop("checked",true);
        }
    });
</script>