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
	public function actionYan(){
		header("content-type:text/html;charset=utf-8");
		$request = \YII::$app->request;
		$name=$request->post("name");
		$pwd=$request->post("pwd");
		$yan=$request->post("code");
//        echo $name;die;
		session_start();
		$authcode=$_SESSION['authcode'];
		if($yan==$authcode){
			$data = (new \yii\db\Query())
				->select(['*'])
				->from('ais_admin')
				->where(['admin_name'=>$name])
				->all();
			if(!empty($data)){
				if($data[0]['password']==$pwd){
					echo 3;
					$_SESSION['name']=$name;
				}else{
					echo 2;
				}
			}else{
				echo 1;
			}

		}else{
			echo 0;
		}
	}
	public function actionOut(){
		$session = Yii::$app->session;
		$session->open();
		unset($session['name']);
		echo "<script> alert('请先登录');window.location.href='?r=login/index';</script>";
	}
}
?>