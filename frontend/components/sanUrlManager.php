<?php


namespace frontend\components;

use Yii;
use yii\web\UrlManager;

class sanUrlManager extends UrlManager
{
    public $enableSanUrl = false;

    public function init()
    {
        parent::init();
    }

    public function createUrl($map)
    {
        $urlHtml = '';
        $params = (array)$map;
       // echo"<pre>";print_r($params);exit;
        if (isset($params[0])) {
            $route = explode('/', trim($params[0], '/'));
            unset($params[0]);
            $controllerName = strtolower($route[0]);
            $actionName = isset($route[1]) ? strtolower($route[1]) : 'index';
            //
           // var_dump($map);exit;
            if($controllerName == 'stock'){
                switch($actionName) {
                    case 'index':
                        $urlHtml ='a'; break;
                    case 'add':
                        $urlHtml ='b'; break;
                    case 'edit':
                        $urlHtml ='c';
                        if(isset($map['goods_id']))
                            $urlHtml.='/'.$map['goods_id'].'.html';
                            break;
                }
            }
            return $urlHtml;
        }
    }
}