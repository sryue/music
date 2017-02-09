<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * 主页
 */
class IndexController extends Controller
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