<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * 音乐风格模块
 */
class MgcController extends Controller
{
	#404时调用
	public $enableCsrfValidation =false;
	#禁用Yii框架的样式
	public $layout = "comm";

	//敏感词设置页面
	public function actionIndex(){
		return $this->render('index');
	}
	//敏感词设置
	public function actionMin(){
		//文件路径
		$file = "./min_gan_ci.txt";
		//接值
		$request = \Yii::$app->request;
		$name1 = ','.$request->get("name1");
		//将接值切分数组
		$arr = explode(',', $name1);

		//将文件内容切分数组
		$arr2 = explode(",",file_get_contents($file));
		//删除重复值
		// $arr3 = array_merge($arr,$arr2);
		foreach ($arr as $key => $val) {
			if(in_array($val,$arr2)){
				unset($arr[$key]);
			}
		}
		//敏感词写入文件  并追加
		$data = file_put_contents($file,implode(',',$arr),FILE_APPEND);
		if($data){
			echo 1;
		}else{
			echo 0;
		}
	}
}
?>