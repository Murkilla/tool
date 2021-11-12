<div class="portlet-body form" >
    <form id="add-form" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" data-act="<?php echo $this->config->default_main; ?>/<?php echo $this->io->input['get']['fun']; ?>/insert">
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-3 control-label">帳號：</label>
                <div class="col-md-9">
                    <input id="account" name="account" type="text" class="form-control" placeholder="請填入帳號" value="<?php if(isset($this->tplVar["obj"])){echo $this->tplVar["obj"]->account;}?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">密碼：</label>
                <div class="col-md-9">
                    <input id="password" name="password" type="password" class="form-control" placeholder="請填入密碼"/>
                </div>
                <label class="col-md-3 control-label"></label>
                <div class="col-md-9">
                    <input id="password_2" name="password_2" type="password" class="form-control" placeholder="確認密碼"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">名稱：</label>
                <div class="col-md-9">
                    <input id="name" name="name" type="text" class="form-control" placeholder="請填入名稱" value="<?php if(isset($this->tplVar["obj"])){echo $this->tplVar["obj"]->name;}?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">存取權限：</label>
                <div class="col-md-9">
                    <select class="form-control" id="role" name="role">
                        <option value="0">請選擇</option>
                        <?php if(is_array($this->tplVar["table"]) && !empty($this->tplVar["table"])):?>
                            <?php foreach($this->tplVar["table"]["record"] as $rk => $rv):?>
                                    <option value="<?php echo $rv["rid"];?>" <?php if(isset($this->tplVar["obj"]) && $this->tplVar['obj']->role == $rv['rid']){echo 'selected';}?> ><?php echo $rv["name"];?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>