<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use yii\data\Pagination;

/**
 * 音乐风格模块
 */
class MstyleController extends CommonController
{
	#404时调用
	public $enableCsrfValidation =false;
	#禁用Yii框架的样式
	public $layout = "comm";

	public function actionIndex(){
		return $this->render('index');
	}
	public function actionAdd(){
		$request = \YII::$app->request;
		$style=$request->post("style");

		$data = (new \yii\db\Query())
			->select(['*'])
			->from('ais_style')
			->where(['style_name'=>$style])
			->all();
		if(empty($data)){
			$sql = "insert into ais_style (style_name) values ('$style')";
			$connection = \Yii::$app->db;
			$re = $connection->createCommand($sql)->execute();
			if($re){
				echo 2;
			}else{
				echo 1;
			}
		}else{
			echo 0;
		}
			

		

	}
	public function actionList(){

		//实例化query
		$query=new Query();

		$query->from('ais_style');

		//分页
		$pagination = new Pagination(['totalCount' => $query->count()]);

		//条数
		$pagination->setPageSize('5');

		//条件
		$query->offset($pagination->offset)->limit($pagination->limit);

		//执行
		$userInfo=$query->all();

		//print_r($userInfo);die;

		return $this->render('list',['data'=>$userInfo,'page'=>$pagination]);
	}
	public function actionStyle_del(){
		$request=\YII::$app->request;
		$id=$request->post('ids');
		$connection = \Yii::$app->db;
		$sql="delete from ais_style where style_id='$id'";
		$re = $connection->createCommand($sql)->execute();
		if($re){
			echo 1;
		}else{
			echo 0;
		}
	}
}
?>