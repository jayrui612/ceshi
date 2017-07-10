
<?php
use \yii\widgets\LinkPager;
?>
<link href="/css/type.css" rel="stylesheet"/>
<script src="/api/jq/5733e32c6dac2/js/moment.min.js"></script>
<!-- Table goes in the document BODY -->
<h1>账目记录 <span class="typeadd" style="color:darkred">总数量：<?=$sum_count?>&nbsp; &nbsp;总毛利:<?=$sum_price?></span></h1>
            <form  action="<?=Yii::$app->urlManager->createUrl(['account/index'])?>" method="post">
                <div class="form-group field-contactform-name required">
                    <label class="control-label" for="contactform-name">开始日期：</label> <input name="start_time" type="text" class="data1" value="<?=date('Y-m-d',$start_time)?>" size="16">
                    &nbsp; &nbsp; &nbsp;
                    <label class="control-label" for="contactform-name">结束日期：</label> <input name="end_time" type="text" class="data2" value="<?=date('Y-m-d',$end_time)?>" size="16">&nbsp; &nbsp; &nbsp;
                    <input type="submit" class="btn btn-primary"  value="搜索">
                    <input type="hidden" name='<?=Yii::$app->request->csrfParam?>' value="<?=Yii::$app->request->csrfToken?>"/>
                    </div>
                </form>
    </span>
<table class="imagetable">
    <tr>
        <th>日期</th><th>维修名称</th><th>维修类型</th><th>消耗库存</th><th>维修费用</th><th>成本价格</th><th>毛利</th>
    </tr>
    <?php if($repairs){?>
    <?php foreach($repairs as $info){?>
        <tr>
            <td><?=date('Y-m-d H:i:s',$info['update_time'])?></td>
            <td><?=$info['repair_name']?></td>
            <td><?=$type[$info['repair_goods_type']]['type_name']?></td>
            <td><?php if($info['repair_goods_id']) {echo $type[$info['repair_goods_type']]['goods'][$info['repair_goods_id']]['goods_name'];}?></td>
            <td><?=$info['repair_price']?></td>
            <td><?=$info['goods_price']?></td>
            <td><?=$info['margin_price']?></td>
        </tr>
    <?php }}else{?>
    <tr>
        <td colspan="7">暂无数据</td>
        </tr>
    <?php } ?>
    <tr>
        <th colspan="3" style="color:red">当前搜索日期维修总数为：<?=$count?></th>
        <th colspan="4" style="color:red">当前搜索日期总共赚取￥<?=$price?>元</th>
    </tr>
</table>
<div class='pagination'>
    <ul>
        <?php
        if ($pagination) {
            echo LinkPager::widget([
                'pagination' => $pagination,
                'activePageCssClass'=>"active",
                'options' => [],

            ]);
        }
        ?>
    </ul>
</div>
<script>
    $(function(){
        $('.date1').each(function(){
            $(this).ionDatePicker({
                lang: 'zh-cn',
                format: 'YYYY-MM-DD'
            });
            $('.date2').each(function(){
                $(this).ionDatePicker({
                    lang: 'zh-cn',
                    format: 'YYYY-MM-DD'
                });
        });
    });
</script>