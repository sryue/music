<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ais_carousel".
 *
 * @property integer $car_id
 * @property string $car_name
 * @property string $car_file
 * @property string $car_content
 */
class AisCarousel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ais_carousel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['car_name', 'car_file', 'car_content'], 'required'],
            [['car_name', 'car_file', 'car_content'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'car_id' => 'Car ID',
            'car_name' => 'Car Name',
            'car_file' => 'Car File',
            'car_content' => 'Car Content',
        ];
    }
}
