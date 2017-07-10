<?php
namespace frontend\controllers;
use yii\web\Controller;
use frontend\models\ConDbStock;
use frontend\models\ConDbType;
use frontend\models\ConDbRepair;
use yii\data\Pagination;
use Yii;
class RepairController extends Controller{

    public function actionIndex()
    {
        $date = date( "Y-m-d" );
        list( $year, $month, $day ) = explode( '-', $date );
        $start_time = mktime( 0, 0, 0, $month, $day, $year );
        $end_time   = mktime( 23, 59, 59, $month, $day, $year );
        $count = ConDbRepair::find()
            ->where(['>=','update_time',$start_time])
            ->andWhere(['<=','update_time',$end_time])
            ->count();
        $pagination = new Pagination(['totalCount' => $count]); //实例化分页类
        $pagination->defaultPageSize = 10; //设置每页条数
        $repair_infos = ConDbRepair::find()
            ->where(['>=','update_time',$start_time])
            ->andWhere(['<=','update_time',$end_time])
            ->limit($pagination->limit)->offset($pagination->offset)
            ->asArray()->all();
        //商品分类 和商品列表 二级联动用
        $goods_type_infos = ConDbType::find()->select('type_id,type_name')->indexBy('type_id')->asArray()->all();
        foreach($goods_type_infos as &$val){
            $val['goods'] = ConDbStock::find()->select('goods_id,goods_name,origin_price')->indexBy('goods_id')->where(['goods_type'=>$val['type_id']])->asArray()->all();
        }
        //总毛利
        $sum_price = ConDbRepair::find()
                    ->where(['>=','update_time',$start_time])
                    ->andWhere(['<=','update_time',$end_time])
                    ->sum('margin_price');
        return $this->render('index',[
            'repairs'      =>  $repair_infos,
            'type'      =>  $goods_type_infos,
            'count'      =>  $count,
            'sum_price'      =>  $sum_price,
            'pagination' => $pagination
        ]);
    }


    public function actionAdd()
    {
        if ( Yii::$app->request->isPost ){
            $arr = Yii::$app->request->post();
            if(!$arr['repair_name'] || !$arr['repair_goods_type'] || !$arr['repair_price'] || ($arr['repair_goods_type'] != 5 && !$arr['repair_goods_id']))
                return "<script>alert('维修名称 或 维修类型 或 消耗库存 或 维修费用不能为空'); window.history.back();</script>";
            $model = new ConDbRepair;
            $model->repair_name    = $arr['repair_name'];
            $model->repair_goods_type       = $arr['repair_goods_type'];
            isset($arr['repair_goods_id']) && $model->repair_goods_id = $arr['repair_goods_id'] ;
            $model->repair_price       = $arr['repair_price'];
            $model->goods_price       = $origin_price = isset($arr['goods_price']) ? $arr['goods_price'] : 0;
            $model->margin_price       = $arr['repair_price'] - $origin_price;
            $model->create_time  = time();
            $model->update_time  = time();
            if ( $model->save()) {
                //消减库存的数量
               if( isset($arr['repair_goods_id'])){
                   $stock_info = ConDbStock::findOne(['goods_id'=>$arr['repair_goods_id']]);
                   $stock_info->num -= 1;
                   $stock_info->save();
               }

                Yii::$app->getSession()->setFlash('success', '添加成功');
                return $this->redirect(Yii::$app->urlManager->createUrl(['repair/index']));
            }else{
                Yii::$app->getSession()->setFlash('error', '添加失败');
                return $this->redirect(Yii::$app->urlManager->createUrl(['repair/add']));
            }
        }
        //商品分类 和商品列表 二级联动用
        $goods_type_infos = ConDbType::find()->select('type_id,type_name')->asArray()->all();
        foreach($goods_type_infos as &$val){
            $val['sub'] = ConDbStock::find()->select('goods_id,goods_name,origin_price')->where(['goods_type'=>$val['type_id']])->asArray()->all();
        }
        return $this->render('addrepair',['type_names'=>json_encode($goods_type_infos)]);
    }

    public function actionEdit()
    {
        if ( Yii::$app->request->isPost ){
            $arr = Yii::$app->request->post();
            if(!$arr['repair_name'] ||  !$arr['repair_price'] )
                return "<script>alert('维修名称 或维修费用不能为空'); window.history.back();</script>";
            $model = ConDbRepair::findOne(['id'=>$arr['id']]);
            $origin_price =  $model->goods_price;
            $model->repair_name    = $arr['repair_name'];
            $model->repair_price       = $arr['repair_price'];
            $model->margin_price       = $arr['repair_price'] - $origin_price;
            $model->update_time  = time();
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', '编辑成功');
            }else{
                Yii::$app->getSession()->setFlash('error', '编辑失败');
            }
            return $this->redirect(Yii::$app->urlManager->createUrl(['repair/index']));
        }
        //显示编辑的数据
        $id = Yii::$app->request->get('id','');
        if(!$id){
            return "<script>alert('非法请求');window.history.back();</script>";
        }
        $repair_info = ConDbRepair::find()->where(['id'=>$id])->asArray()->one();
        //商品分类 和商品列表 二级联动用
        $goods_type_infos = ConDbType::find()->select('type_id,type_name')->asArray()->all();
        foreach($goods_type_infos as &$val){
            $val['sub'] = ConDbStock::find()->select('goods_id,goods_name,origin_price')->where(['goods_type'=>$val['type_id']])->asArray()->all();
        }
        return $this->render('editrepair',[
            'info'      =>  $repair_info,
            'type_names'      => json_encode($goods_type_infos),
        ]);
    }

    public function actionDel()
    {
        $id = Yii::$app->request->get('id','');
        if(!$id){
            return "<script>alert('非法请求');window.history.back();</script>";
        }
        $info = ConDbRepair::findOne(['id'=>$id]);
        if($info->delete()){
            Yii::$app->getSession()->setFlash('success', '删除成功');
        }else{
            Yii::$app->getSession()->setFlash('error', '删除失败');
        }
        return $this->redirect(Yii::$app->urlManager->createUrl(['repair/index']));
    }


}