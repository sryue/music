<?php 
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $song;
    public $songbest;
    public $lyrics;

    public function rules()
    {
        return [
            [['song'], 'file', 'skipOnEmpty' => false],
            [['songbest'], 'file', 'skipOnEmpty' => false],
            [['lyrics'], 'file', 'skipOnEmpty' => false],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'song' => '',
            'songbest' => '',
            'lyrics' => '',
        ];
    }
}
 ?>