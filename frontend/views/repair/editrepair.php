
            <h1>编辑维修记录</h1>
            <div class="row">
                <div class="col-lg-5">
                    <form  action="<?=Yii::$app->urlManager->createUrl(['repair/edit'])?>" method="post">
                        <input type="hidden" name="id" value="<?=$info['id']?>">
                        <div class="form-group field-contactform-name required">
                            <label class="control-label" for="contactform-name">维修名称*</label>
                            <input type="text" class="form-control"  value="<?=$info['repair_name']?>" name="repair_name"   autofocus aria-required="true">
                        </div>
                        <div class="form-group field-contactform-subject required">
                            <label class="control-label" for="contactform-subject">维修类型*</label>
                            <span class="selectList">
                            <select class="form-control default-first" name="repair_goods_type" disabled="disabled" aria-required="true">
                                <option value="">请选择</option>
                            </select>
                                  <label class="control-label" for="contactform-subject">消耗库存*</label>
                            <select class="form-control default-second" name="repair_goods_id"  aria-required="true">
                                <option value="">请选择</option>
                            </select>
                                </span>
                        </div>

                        <div class="form-group field-contactform-name required">
                            <label class="control-label" for="contactform-name">维修费用*</label>
                            <input type="text" class="form-control" name="repair_price"  value="<?=$info['repair_price']?>"  autofocus aria-required="true" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
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
            <script>
                $(function(){
                    $.fn.mutipleSelect = function (options) {
                        var opts = $.extend({}, $.fn.mutipleSelect.defaults, options);

                        function isArray(object) {
                            return object && typeof object === 'object' &&
                                Array == object.constructor;
                        }

                        return this.each(function () {

                            var default_select = "<option value=''>请选择</option>";

                            var temp_html = default_select;

                            var levelFirstEl = $(this).find(opts.levelFirstEl),
                                levelSecondEl = $(this).find(opts.levelSecondEl).attr("disabled", "disabled");

                            var initToDefault=function(index){
                                opts.initSelect[index]="-1";
                            }

//初始化levelfirst
                            var initLevelfirst = function () {
                                if (!isArray(opts.dataJson)) {
                                    console.info("一级数据不是数组");
                                    return
                                }

                                $.each(opts.dataJson, function (i, item) {
                                    temp_html += "<option value='" + item.type_id + "'>" + item.type_name + "</option>";
                                });

                                levelFirstEl.html(temp_html);
                                if(opts.initSelect[0]!=-1){
                                    levelFirstEl.val(opts.initSelect[0]);
                                    levelSecondEl.removeAttr("disabled");
                                    initToDefault(0);
                                }

                                initLevelsecond();
                            }

//初始化levelsecond
                            var initLevelsecond = function () {
                                temp_html = default_select;
                                var n = levelFirstEl.get(0).selectedIndex - 1;

                                if (n >= 0) {
                                    levelSecondEl.attr("disabled", "disabled");
                                } else {
                                    levelSecondEl.attr("disabled", "disabled");
                                    n = 0;
                                }

                                if (opts.dataJson[n] && isArray(opts.dataJson[n].sub)) {
                                    $.each(opts.dataJson[n].sub, function (i, item) {
                                        temp_html += "<option value='" + item.goods_id + "' data-price='" + item.origin_price + "'>" + item.goods_name + "</option>";
                                    });

                                } else {
                                    console.info("二级数据不是数组");
                                }

                                levelSecondEl.html(temp_html);

                                if(opts.initSelect[1]!=-1){
                                    levelSecondEl.val(opts.initSelect[1]);
                                    initToDefault(1);
                                }
                            };


                            levelFirstEl.change(function () {
                                initLevelsecond();
                            });

                            initLevelfirst();
                        });
                    };
                    $.fn.mutipleSelect.defaults={
                        levelFirstEl: '.default-first',
                        levelSecondEl: '.default-second',
                        initSelect:["<?=$info['repair_goods_type']?>","<?=$info['repair_goods_id']?>"],
                        dataJson: []
                    }
                });


                $(function(){
                    var data = <?=$type_names?>;
                    $('.selectList').mutipleSelect({
                        levelFirstEl:'.default-first',
                        levelDecondEL:'.default-second',
                        dataJson:data
                    });
                });


            </script>

