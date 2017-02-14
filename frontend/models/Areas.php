<?php
namespace frontend\models;

use yii\db\ActiveRecord;
class Areas extends ActiveRecord
{
    public function Getarea($data)
    {
        return $this::find()->where($data);
    }

}