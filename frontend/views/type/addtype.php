
            <h1>添加分类</h1>
            <div class="row">
                <div class="col-lg-5">
                    <form  action="<?=Yii::$app->urlManager->createUrl(['type/add'])?>" method="post">
                        <div class="form-group field-contactform-name required">
                            <label class="control-label" for="contactform-name">分类名称*</label>
                            <input type="text" class="form-control" name="type_name"   autofocus aria-required="true">
                        </div>
                        <div class="form-group field-contactform-subject required">
                            <label class="control-label" for="contactform-subject">分类状态*</label>
                            <select class="form-control" name="status" aria-required="true">
                                <option value="0">请选择</option>
                                <?php foreach(Yii::$app->params['status'] as $key => $val){?>
                                    <option value="<?=$key?>"<?php if(1 == $key){echo"selected";} ?>><?=$val?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name='<?=Yii::$app->request->csrfParam?>' value="<?=Yii::$app->request->csrfToken?>"/>
                            <input type="reset" class="btn btn-success" value="重置">  &nbsp;&nbsp;&nbsp;  |
                            &nbsp; &nbsp; &nbsp;
                            <input type="submit" class="btn btn-primary"  value="添加">
                        </div>

                    </form>        </div>
            </div>

        </div>
    </div>
</div>
