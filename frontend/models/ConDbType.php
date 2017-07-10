<?php

namespace frontend\models;

use Yii;

class ConDbType extends \yii\db\ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->db;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_type';
    }

    public function getToppic(){

    }

}
