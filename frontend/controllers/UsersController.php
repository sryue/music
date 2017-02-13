<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use yii\data\Pagination;

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
		header("content-type:text/html;charset=utf-8");

		//实例化query
		$query=new Query();

		$query->from('ais_user');

		//分页
		$pagination = new Pagination(['totalCount' => $query->count()]);

		//条数
		$pagination->setPageSize('5');

		//条件
		$query->offset($pagination->offset)->limit($pagination->limit);

		//执行
		$userInfo=$query->all();

		//print_r($userInfo);die;

		return $this->render('show',['data'=>$userInfo,'page'=>$pagination]);
	}
	public function actionDel(){
		$request=\YII::$app->request;
		$id=$request->post('ids');
		$connection = \Yii::$app->db;
		$sql="delete from ais_user where user_id='$id'";
		$re = $connection->createCommand($sql)->execute();
		if($re){
			echo 1;
		}else{
			echo 0;
		}
	}
	
}
?>