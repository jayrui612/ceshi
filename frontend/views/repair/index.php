
<?php
use \yii\widgets\LinkPager;
?>
<link href="/css/type.css" rel="stylesheet"/>
<!-- Table goes in the document BODY -->
<h1>今日维修列表 <span class="typeadd"><a href="<?=Yii::$app->urlManager->createUrl(['repair/add'])?>">添加维修记录</a> </span></h1>
<table class="imagetable">
    <tr>
        <th>维修名称</th><th>维修类型</th><th>消耗库存</th><th>维修费用</th><th>成本价格</th><th>毛利</th><th>操作日期</th><th>操作</th>
    </tr>
    <?php foreach($repairs as $info){?>
        <tr>
            <td><?=$info['repair_name']?></td>
            <td><?=$type[$info['repair_goods_type']]['type_name']?></td>
            <td><?php if($info['repair_goods_id']) {echo $type[$info['repair_goods_type']]['goods'][$info['repair_goods_id']]['goods_name'];}?></td>
            <td><?=$info['repair_price']?></td>
            <td><?=$info['goods_price']?></td>
            <td><?=$info['margin_price']?></td>
            <td><?=date('Y-m-d H:i:s',$info['update_time'])?></td>
            <td><a href="<?=Yii::$app->urlManager->createUrl(['repair/edit','id'=>$info['id']])?>">编辑</a>
                | <a href="<?=Yii::$app->urlManager->createUrl(['repair/del','id'=>$info['id']]) ?>">删除</a></td>
        </tr>
    <?php }?>
    <tr>
        <th colspan="4">今日维修数：<?=$count?></th>
        <th colspan="4">今日总毛利：<?=$sum_price?></th>
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
