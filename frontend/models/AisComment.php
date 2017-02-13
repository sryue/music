<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ais_comment".
 *
 * @property string $comm_id
 * @property string $comm_content
 * @property integer $user_id
 * @property string $comm_time
 * @property integer $praise
 * @property integer $contempt
 * @property integer $music_id
 */
class AisComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ais_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comm_content', 'user_id', 'comm_time', 'praise', 'music_id'], 'required'],
            [['user_id', 'praise', 'contempt', 'music_id'], 'integer'],
            [['comm_time'], 'safe'],
            [['comm_content'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comm_id' => 'Comm ID',
            'comm_content' => 'Comm Content',
            'user_id' => 'User ID',
            'comm_time' => 'Comm Time',
            'praise' => 'Praise',
            'contempt' => 'Contempt',
            'music_id' => 'Music ID',
        ];
    }
}
