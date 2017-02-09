<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * 登录模块
 */
class LoginController extends Controller
{
	#404时调用
	public $enableCsrfValidation =false;
	#禁用Yii框架的样式
	public $layout = false;

	public function actionIndex(){
		return $this->render('index');
	}
}
?>