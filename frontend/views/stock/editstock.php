
            <h1>编辑商品</h1>
            <div class="row">
                <div class="col-lg-5">
                    <form  action="<?=Yii::$app->urlManager->createUrl(['stock/edit'])?>" method="post">
                        <input type="hidden" name="goods_id" value="<?=$info['goods_id']?>">
                        <div class="form-group field-contactform-name required">
                            <label class="control-label" for="contactform-name">商品名称*</label>
                            <input type="text" class="form-control" name="goods_name" value="<?=$info['goods_name']?>" autofocus aria-required="true">
                        </div>
                        <div class="form-group field-contactform-subject required">
                            <label class="control-label" for="contactform-subject">商品分类*</label>
                            <select class="form-control" name="goods_type" aria-required="true">
                                <option value="0">请选择</option>
                                <?php foreach($type_names as $key => $val){?>
                                    <option value="<?=$key?>" <?php if($info['goods_type'] == $key){echo"selected";} ?>><?=$val['type_name']?></option>
                                <?php }?>
                            </select>
                        </div>

                        <div class="form-group field-contactform-name required">
                            <label class="control-label" for="contactform-name">商品单价*</label>
                            <input type="text" class="form-control" name="origin_price" value="<?=$info['origin_price']?>"  autofocus aria-required="true" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
                        </div>
                        <div class="form-group field-contactform-name required">
                            <label class="control-label" for="contactform-name">商品数量*</label>
                            <input type="text" class="form-control" name="num"  value="<?=$info['num']?>" autofocus aria-required="true" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name='<?=Yii::$app->request->csrfParam?>' value="<?=Yii::$app->request->csrfToken?>"/>
                            <input type="reset" class="btn btn-success" value="重置">  &nbsp;&nbsp;&nbsp;  |
                            &nbsp; &nbsp; &nbsp;
                            <input type="submit" class="btn btn-primary"  value="编辑">
                        </div>
                    </form>        </div>
            </div>

        </div>
    </div>
</div>
