
<?php
use \yii\widgets\LinkPager;
?>
<link href="/css/type.css" rel="stylesheet"/>
<!-- Table goes in the document BODY -->
<h1>分类列表 <span class="typeadd"><a href="<?=Yii::$app->urlManager->createUrl(['type/add'])?>">添加分类</a> </span></h1>
<table class="imagetable">
    <tr>
        <th>现有分类</th><th>分类状态</th><th>创建日期</th><th>修改日期</th><th>操作</th>
    </tr>
    <?php foreach($infos as $info){ ?>
    <tr>
            <td><?=$info['type_name']?></td>
            <td><?=Yii::$app->params['status'][$info['status']]?></td>
             <td><?=date('Y-m-d H:i:s',$info['create_time'])?></td>
             <td><?php if($info['update_time']) echo date('Y-m-d H:i:s',$info['update_time'])?></td>
             <td><a href="<?=Yii::$app->urlManager->createUrl(['type/edit','type_id'=>$info['type_id']])?>">编辑</a>
                 | <a href="<?=Yii::$app->urlManager->createUrl(['type/del','type_id'=>$info['type_id']])
                 ?>">删除</a></td>
    </tr>
    <?php }?>
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
