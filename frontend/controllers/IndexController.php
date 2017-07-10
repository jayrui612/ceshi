<?php
namespace frontend\controllers;
use yii\web\Controller;
use common\models\DbMsg;
use Yii;
class IndexController extends Controller{

    public function actionIndex()
    {
        if ( Yii::$app->request->isPost ){
              $arr = Yii::$app->request->post();
            $msg = new DbMsg;
           $msg->user = $arr['author'];
           $msg->msg = $arr['msg'];
            if($msg->save()){
                $infos = DbMsg::find()->asArray()->all();
                return json_encode(['msg'=>1,'data'=>$infos]);
            }else{
                return 'xxxxx';
            }
        }
        return $this->render('index');
    }



}
