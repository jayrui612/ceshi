<?php
namespace frontend\controllers;
use yii\web\Controller;
use frontend\models\ConDbStock;
use frontend\models\ConDbType;
use common\models\DbGoods;
use common\models\DbType;
use yii\data\Pagination;
use Yii;
class StockController extends Controller{

    public function actionIndex()
    {
        $arr = [
            0 =>[
                'name' => 'jayrui612',
                'age'  => 27,
            ],
            1=>[
                'name' => 'raydu',
                'age'  => 22,
            ],
        ];
        $info = json_decode(Yii::$app->redis->get('jay:you'),true);
         Yii::$app->redis->set("jay:you",json_encode($arr,true));
        Yii::$app->redis->expire("jay:you",30);
       $infos =  DbGoods::find()->innerJoinWith('type')->asArray()->one();
      // $infos =  DbType::find()->innerJoinWith('goods')->innerJoinWith('repair')->where(['type_id'=>1])->asArray()
       // ->one();
       //$infos =  DbType::find()->joinWith('goods')->where(['type_id'=>1])->asArray()->one();
       $infos =  DbType::findOne(['type_id'=>1]);
        echo"<pre>";print_R( $infos);exit;
        $count = ConDbStock::find()->count();
        $pagination = new Pagination(['totalCount' => $count]); //实例化分页类
        $pagination->defaultPageSize = 10; //设置每页条数
        $stock_infos = ConDbStock::find() ->limit($pagination->limit)->offset($pagination->offset)->asArray()->all();
        $type_names  = ConDbType::find()
            ->select('type_id,type_name')
            ->indexBy('type_id')
            ->where(['status'=>1])
            ->asArray()
            ->all();
        $sum_price = ConDbStock::find()->sum('sum_price');
        $count = ConDbStock::find()->sum('num');
        return $this->render('index',[
            'stocks'      =>  $stock_infos,
            'type_names'      =>  $type_names,
            'count'      =>  $count,
            'sum_price'      =>  $sum_price,
            'pagination' => $pagination
        ]);
    }


    public function actionAdd()
    {
        if ( Yii::$app->request->isPost ){
            $arr = Yii::$app->request->post();
            if(!$arr['goods_name'] || !$arr['goods_type'] || !$arr['origin_price'] || !$arr['num'])
                return "<script>alert('商品名称 或 商品分类 或 商品单价 或 商品数量不能为空'); window.history.back();</script>";
            $model = new ConDbStock;
            $model->goods_name    = $arr['goods_name'];
            $model->goods_type       = $arr['goods_type'];
            $model->origin_price       = $arr['origin_price'];
            $model->sum_price       = $arr['origin_price']*$arr['num'];
            $model->num       = $arr['num'];
            $model->create_time  = time();
            if ( $model->save()) {
                Yii::$app->getSession()->setFlash('success', '添加成功');
                return $this->redirect(Yii::$app->urlManager->createUrl(['stock/index']));
            }else{
                Yii::$app->getSession()->setFlash('error', '添加失败');
                return $this->redirect(Yii::$app->urlManager->createUrl(['stock/add']));
            }
        }
        $type_names  = ConDbType::find()->select('type_id,type_name')->indexBy('type_id') ->where(['status'=>1])->asArray()->all();
        return $this->render('addStock',['type_names'=>$type_names]);
    }

    public function actionEdit()
    {
        if ( Yii::$app->request->isPost ){
            $arr = Yii::$app->request->post();
            if(!$arr['goods_name'] || !$arr['goods_type'] || !$arr['origin_price'] || !$arr['num'])
                return "<script>alert('商品名称 或 商品分类 或 商品单价 或 商品数量不能为空'); window.history.back();</script>";
            $info = ConDbStock::findOne(['goods_id'=>$arr['goods_id']]);
            if(!$info)
                return $this->redirect(Yii::$app->urlManager->createUrl(['stock/index']));
            $info->goods_name    = $arr['goods_name'];
            $info->goods_type       = $arr['goods_type'];
            $info->origin_price       = $arr['origin_price'];
            $info->sum_price       = $arr['origin_price']*$arr['num'];
            $info->num       = $arr['num'];
            $info->update_time  = time();
            if($info->save()){
                Yii::$app->getSession()->setFlash('success', '编辑成功');
            }else{
                Yii::$app->getSession()->setFlash('error', '编辑失败');
            }
            return $this->redirect(Yii::$app->urlManager->createUrl(['stock/index']));
        }
     //  var_dump(Yii::$app->urlManager->createUrl(['stock/edit','goods_id'=>3])) ;exit;
        $goods_id = Yii::$app->request->get('id','');
        if(!$goods_id){
            return "<script>alert('非法请求');window.history.back();</script>";
        }
        $stock_info = ConDbStock::find()->where(['goods_id'=>$goods_id])->asArray()->one();
        $type_names  = ConDbType::find()->select('type_id,type_name')->indexBy('type_id') ->where(['status'=>1])->asArray()->all();
        return $this->render('editstock',[
            'info'      =>  $stock_info,
            'type_names'      =>  $type_names,
        ]);
    }

    public function actionDel()
    {
        $goods_id = Yii::$app->request->get('goods_id','');
        if(!$goods_id){
            return "<script>alert('非法请求');window.history.back();</script>";
        }
        $info = ConDbStock::findOne(['goods_id'=>$goods_id]);
        if($info->delete()){
            Yii::$app->getSession()->setFlash('success', '删除成功');
        }else{
            Yii::$app->getSession()->setFlash('error', '删除失败');
        }
        return $this->redirect(Yii::$app->urlManager->createUrl(['stock/index']));
    }


}