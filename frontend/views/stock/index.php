
<?php
use \yii\widgets\LinkPager;

?>
<!-- Table goes in the document BODY -->
<h1>库存列表 <span class="typeadd"><a href="<?=Yii::$app->urlManager->createUrl(['stock/add'])?>">添加商品</a> </span></h1>
<table class="imagetable">
    <tr>
        <th>商品名称</th><th>商品类型</th><th>商品进价</th><th>商品库存</th><th>商品总进价</th><th>创建日期</th><th>操作</th>
    </tr>
    <?php foreach($stocks as $info){?>
    <tr>
            <td><?=$info['goods_name']?></td>
            <td><?=$type_names[$info['goods_type']]['type_name']?></td>
            <td><?=$info['origin_price']?></td>
            <td><?=$info['num']?></td>
            <td><?=$info['num']*$info['origin_price']?></td>
             <td><?=date('Y-m-d H:i:s',$info['create_time'])?></td>
             <td><a href="<?=Yii::$app->urlManager->createUrl(['stock/edit','goods_id'=>$info['goods_id']])?>">编辑</a>
                 | <a href="<?=Yii::$app->urlManager->createUrl(['stock/del','goods_id'=>$info['goods_id']]) ?>">删除</a></td>
    </tr>
    <?php }?>
    <tr>
        <th colspan="3">库存总数量：<?=$count?></th>
        <th colspan="4">商品总成本：<?=$sum_price?></th>
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
