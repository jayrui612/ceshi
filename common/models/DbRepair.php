<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "repair_goods".
 *
 * @property string $id
 * @property string $repair_name
 * @property integer $repair_goods_type
 * @property integer $repair_goods_id
 * @property string $repair_price
 * @property string $goods_price
 * @property string $margin_price
 * @property integer $create_time
 * @property integer $update_time
 */
class DbRepair extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repair_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['repair_goods_type', 'repair_price', 'goods_price', 'margin_price', 'create_time', 'update_time'], 'required'],
            [['repair_goods_type', 'repair_goods_id', 'create_time', 'update_time'], 'integer'],
            [['repair_price', 'goods_price', 'margin_price'], 'number'],
            [['repair_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'repair_name' => 'Repair Name',
            'repair_goods_type' => 'Repair Goods Type',
            'repair_goods_id' => 'Repair Goods ID',
            'repair_price' => 'Repair Price',
            'goods_price' => 'Goods Price',
            'margin_price' => 'Margin Price',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
