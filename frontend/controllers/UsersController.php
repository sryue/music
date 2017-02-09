<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * 用户页面
 */
class UsersController extends Controller
{
	#404时调用
	public $enableCsrfValidation =false;
	#禁用Yii框架的样式
	public $layout = 'comm';

	//添加用户页面
	public function actionIndex(){
		return $this->render('index');
	}

	//用户展示页面
	public function actionShow(){
		return $this->render('show');
	}
	
}
?>