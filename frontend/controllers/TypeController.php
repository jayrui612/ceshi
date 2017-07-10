<?php
namespace frontend\controllers;
use yii\web\Controller;
use frontend\models\ConDbType;
use yii\data\Pagination;
use Yii;
class TypeController extends Controller{

    public function actionIndex()
    {
        $count = ConDbType::find()->count();
        $pagination = new Pagination(['totalCount' => $count]); //实例化分页类
        $pagination->defaultPageSize = 10; //设置每页条数
        $type_infos = ConDbType::find() ->limit($pagination->limit)->offset($pagination->offset)->asArray()->all();
        return $this->render('index',[
            'infos'      =>  $type_infos,
            'pagination' => $pagination
        ]);
    }

    public function actionAdd()
    {
        if ( Yii::$app->request->isPost ){
            $arr = Yii::$app->request->post();
            if(!$arr['type_name'] || !$arr['status'])
                return "<script>alert('分类名称或状态不能为空'); window.history.back();</script>";
            $model = new ConDbType;
            $model->type_name    = $arr['type_name'];
            $model->status       = $arr['status'];
            $model->create_time  = time();
            if ( $model->save()) {
                Yii::$app->getSession()->setFlash('success', '添加成功');
                return $this->redirect(Yii::$app->urlManager->createUrl(['type/index']));
            }else{
                Yii::$app->getSession()->setFlash('error', '添加失败');
                return $this->redirect(Yii::$app->urlManager->createUrl(['type/add']));
            }
        }
        return $this->render('addtype');
    }

    public function actionEdit()
    {
        if ( Yii::$app->request->isPost ){
           $arr = Yii::$app->request->post();
            if(!$arr['type_name'] || !$arr['status'])
                return "<script>alert('分类名称或状态不能为空'); window.history.back();</script>";
            $info = ConDbType::findOne(['type_id'=>$arr['type_id']]);
            if(!$info)
                return $this->redirect(Yii::$app->urlManager->createUrl(['type/index']));
            $info->type_name    = $arr['type_name'];
            $info->status       = $arr['status'];
            $info->update_time  = time();
            if($info->save()){
                Yii::$app->getSession()->setFlash('success', '编辑成功');
            }else{
                Yii::$app->getSession()->setFlash('error', '编辑失败');
            }
            return $this->redirect(Yii::$app->urlManager->createUrl(['type/index']));
        }
        $goods_type_id = Yii::$app->request->get('type_id','');
        if(!$goods_type_id){
            return "<script>alert('非法请求');window.history.back();</script>";
        }
        $type_info = ConDbType::find()->where(['type_id'=>$goods_type_id])->asArray()->one();
        return $this->render('edittype',['info'=>$type_info]);
    }

    public function actionDel()
    {
        $type_id = Yii::$app->request->get('type_id','');
        if(!$type_id){
            return "<script>alert('非法请求');window.history.back();</script>";
        }
        $type_info = ConDbType::findOne(['type_id'=>$type_id]);
        if($type_info->delete()){
            Yii::$app->getSession()->setFlash('success', '删除成功');
        }else{
            Yii::$app->getSession()->setFlash('error', '删除失败');
        }
        return $this->redirect(Yii::$app->urlManager->createUrl(['type/index']));
    }


}
