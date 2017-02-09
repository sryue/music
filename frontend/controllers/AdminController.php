<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * 管理员模块
 */
class AdminController extends Controller
{
	#404时调用
	public $enableCsrfValidation =false;
	#禁用Yii框架的样式
	public $layout = 'comm';

	public function actionIndex(){
		return $this->render('index');
	}
}
?>