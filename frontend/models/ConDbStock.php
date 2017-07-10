<?php

namespace frontend\models;

use Yii;

class ConDbStock extends \yii\db\ActiveRecord
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
        return 'goods';
    }

}
