<?php
namespace frontend\controllers;
use yii\web\Controller;
use frontend\models\ConDbStock;
use frontend\models\ConDbType;
use frontend\models\ConDbRepair;
use yii\data\Pagination;
use Yii;
class AccountController extends Controller{

    public function actionIndex()
    {
        $end_time = Yii::$app->request->get('end_time',date( "Y-m-d" ));
        $start_time = Yii::$app->request->get('start_time',date( "Y-m-d",1496700366));
        list( $s_year, $s_month, $s_day ) = explode( '-', $start_time );
        list( $e_year, $e_month, $e_day ) = explode( '-',$end_time );
        $start_time = mktime( 0, 0, 0, $s_month, $s_day, $s_year );
        $end_time   = mktime( 23, 59, 59, $e_month, $e_day, $e_year );

        //搜索功能
        if ( Yii::$app->request->isPost  ){
            $arr = Yii::$app->request->post();
            if($arr['start_time'] || $arr['end_time']){
                list( $s_year, $s_month, $s_day ) = explode( '-', $arr['start_time'] );
                list( $e_year, $e_month, $e_day ) = explode( '-', $arr['end_time'] );
                $start_time = mktime( 0, 0, 0, $s_month, $s_day, $s_year );
                $end_time   = mktime( 23, 59, 59, $e_month, $e_day, $e_year );
            }
        }
        $count = ConDbRepair::find()
            ->where(['>=','update_time',$start_time])
            ->andWhere(['<=','update_time',$end_time])
            ->count();
        $price = ConDbRepair::find()
            ->where(['>=','update_time',$start_time])
            ->andWhere(['<=','update_time',$end_time])
            ->sum('margin_price');
        $pagination = new Pagination(['totalCount' => $count]); //实例化分页类
        $pagination->defaultPageSize = 10; //设置每页条数
        $pagination->params = array_merge(Yii::$app->request->getQueryParams(), ['start_time' => date('Y-m-d',$start_time), 'end_time'=>date('Y-m-d',$end_time)]);
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
                    ->where(['>=','update_time',1430773505])
                    ->sum('margin_price');
        $sum_count = ConDbRepair::find()
            ->where(['>=','update_time',1430773505])
            ->count();
        return $this->render('index',[
            'repairs'      =>  $repair_infos,
            'type'      =>  $goods_type_infos,
            'count'      =>  $count,
            'sum_count'      =>  $sum_count,
            'start_time'      =>  $start_time,
            'end_time'      =>  $end_time,
            'sum_price'      =>  $sum_price,
            'price'      =>  isset($price)?$price:'',
            'pagination' => $pagination
        ]);
    }







}