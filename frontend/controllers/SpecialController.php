<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * 专辑模块
 */
class SpecialController extends Controller
{
	#404时调用
	public $enableCsrfValidation =false;
	#禁用Yii框架的样式
	public $layout = "comm";

	public function actionIndex(){
		return $this->render('index');
	}
}
?>