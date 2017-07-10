<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_type".
 *
 * @property string $type_id
 * @property string $type_name
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */
class DbType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'create_time', 'update_time'], 'integer'],
            [['type_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type_id' => 'Type ID',
            'type_name' => 'Type Name',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    public function getGoods(){
        //一个type表中的id 在goods表中有多个数据，所以用hasmany
        return $this->hasMany(DbGoods::className(),['goods_id'=>'repair_goods_id'])
            ->viaTable('repair_goods',['repair_goods_type'=>'type_id']);
    }




}
