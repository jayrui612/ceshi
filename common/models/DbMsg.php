<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "msg".
 *
 * @property string $id
 * @property string $user
 * @property string $msg
 * @property string $create_time
 */
class DbMsg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time'], 'safe'],
            [['user'], 'string', 'max' => 64],
            [['msg'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'msg' => 'Msg',
            'create_time' => 'Create Time',
        ];
    }
}
