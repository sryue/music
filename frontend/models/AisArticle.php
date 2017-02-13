<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ais_article".
 *
 * @property integer $art_id
 * @property string $art_title
 * @property string $art_content
 * @property string $art_starttime
 * @property string $art_img
 */
class AisArticle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ais_article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['art_content'], 'string'],
            [['art_title', 'art_starttime', 'art_img'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'art_id' => 'Art ID',
            'art_title' => 'Art Title',
            'art_content' => 'Art Content',
            'art_starttime' => 'Art Starttime',
            'art_img' => 'Art Img',
        ];
    }
}
