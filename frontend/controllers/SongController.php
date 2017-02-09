<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * 歌曲模块
 */
class SongController extends Controller
{
	#404时调用
	public $enableCsrfValidation =false;
	#禁用Yii框架的样式
	public $layout = 'comm';

	//添加歌曲页面
	public function actionIndex(){
		return $this->render('index');
	}


	//歌曲列表
	public function actionShow(){
		return $this->render('show');
	}


	//歌曲评论列表
	public function actionDiscuss(){
		return $this->render('discuss');
	}
}
?>