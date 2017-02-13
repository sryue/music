<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\AisCarousel;
use yii\web\UploadedFile;
/**
 * 系统模块
 */
class SystemsController extends Controller
{
	#404时调用
	public $enableCsrfValidation =false;
	#禁用Yii框架的样式
	public $layout = "comm";

	public function actionIndex(){
		return $this->render('index');
	}

	//轮播图的添加
	public function actionCarousel(){
		//实例化M
		$modelObj = new AisCarousel();
		//接收post值
		$request = \Yii::$app->request;
		//判断是不是图片接收
		if($request->isPost){
			//接收图片的信息值
			$image = UploadedFile::getInstanceByName('car_file');
			//打印看看 有接着做没有换另一种方法  var_dump($images);die;
			//上传目录，进行命名
			$dir = Yii::$app->request->hostInfo;
			$dir = 'instyle/images/carousel/';
			// mkdir($dir);
			//文件的绝对路径
			$name = $dir.$image->name;//echo $name;
			//保存文件函数，将图片保存到本地
			$status = $image->saveAs($name,true);
			// echo $status;   //这个打印出来的是1！！
			//进行判断,保存本地失败，输出3
			if($status){
				$names = $image->name;
				//定义添加图片路径
				$modelObj->car_file=$names;

				//调用model层attributes方法，将post接值数据一起（这是将表单中的其他值接受过来，一起入库使的）
				$modelObj->attributes = $request->post();
				$data = $modelObj->save();
				if($data){
					//成功	
					 echo "<script>alert('添加成功');location.href='?r=systems/carousel_show'</script>";
				}else{
					//失败
					echo "<script>alert('添加失败');history.go(-1);</script>";
				}
			}else{
				echo "<script>alert('保存本地失败');history.go(-1);</script>";
			}
		}else{
			echo "<script>alert('格式不正确');history.go(-1);</script>";
		}
	}
	//轮播图列表
	public function actionCarousel_show(){
		//实例化M
		$modelObj = new AisCarousel();
		//接收post值
		$request = \Yii::$app->request;
		$data = $modelObj::find()->asArray()->all();
		return $this->render('carousel_show',['data'=>$data]);
	}
	public function actionDel(){
		
		//接收值
		$request = \Yii::$app->request;
		$id = $request->post("id");
	
		//删除操作
		$modelObj = AisCarousel::findOne($id);
		//获取图片名称
		$file = $modelObj['car_file'];
		$data = $modelObj->delete();

		//图片路径
		$link = './instyle/images/carousel/'.$file;
		if($data){
			unlink($link);
			echo "1";
		}else
			echo "0";
	}

}
?>