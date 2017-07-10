<?php

namespace frontend\models;

use Yii;

class ConDbRepair extends \yii\db\ActiveRecord
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
        return 'repair_goods';
    }

}
