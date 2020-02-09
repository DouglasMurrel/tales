<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class UserService extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_service';
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'id_user'])->inverseOf('user_service');
    }
}