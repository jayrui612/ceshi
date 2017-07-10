<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property string $goods_id
 * @property string $goods_name
 * @property integer $goods_type
 * @property integer $create_time
 * @property string $origin_price
 * @property integer $num
 * @property integer $update_time
 * @property string $sum_price
 */
class DbGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_type', 'create_time', 'origin_price', 'update_time', 'sum_price'], 'required'],
            [['goods_type', 'create_time', 'num', 'update_time'], 'integer'],
            [['origin_price', 'sum_price'], 'number'],
            [['goods_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_id' => 'Goods ID',
            'goods_name' => 'Goods Name',
            'goods_type' => 'Goods Type',
            'create_time' => 'Create Time',
            'origin_price' => 'Origin Price',
            'num' => 'Num',
            'update_time' => 'Update Time',
            'sum_price' => 'Sum Price',
        ];
    }

    public  function getType(){
        return $this->hasOne(Dbtype::className(),['type_id'=>'goods_type']);
    }
}
