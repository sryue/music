<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\AisCarousel;
use yii\web\UploadedFile;
use app\models\Config;
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
	//网站配置
	public function actionConfig()
	{
		$configObj = new Config();
		$configList = $configObj->find()->orderBy('conf_order asc')->asArray()->all();
		foreach ($configList as $k=>$v)
		{
			switch ($v['field_type'])
			{
				case 'text':
					$configList[$k]['conf_content'] = "<input type='text' value='$v[conf_content]' name='data[$v[conf_id]][conf_content]' size='30'/>";
					break;
				case 'textarea':
					$configList[$k]['conf_content'] = "<textarea name='data[$v[conf_id]][conf_content]' cols='30' rows='5'>". $v['conf_content']."</textarea>";
					break;
				case 'radio':
					$arr = explode(',',$v['field_value']);
					$configList[$k]['conf_content'] = '';
					foreach ($arr as $key=>$val)
					{
						if($v['conf_content'] == $val)
						{
							$configList[$k]['conf_content'] .= "<input type='radio' name='data[$v[conf_id]][conf_content]' value='$val' checked>".$val;
							$configList[$k]['conf_content'] .= "&nbsp;&nbsp;";
						}else{
							$configList[$k]['conf_content'] .= "<input type='radio' name='data[$v[conf_id]][conf_content]' value='$val' >".$val;
							$configList[$k]['conf_content'] .= "&nbsp;&nbsp;";
						}
					}
					break;
			}
		}
//		print_r($configList);die;
		return $this->render('config',['configList'=>$configList]);
	}
	//添加配置
	public function actionCreateconfig()
	{
		$data['field_value'] = '';
		if($data = Yii::$app->request->post()){
			$configObj = new Config();
			$configObj->conf_title = $data['conf_title'];
			$configObj->conf_name = $data['conf_name'];
			$configObj->conf_title = $data['conf_title'];
			$configObj->field_type = $data['field_type'];
			$configObj->conf_order = $data['conf_order'];
			$configObj->conf_tips = $data['conf_tips'];
			$configObj->field_value = $data['field_value'];
			$res = $configObj->save();
			if($res)
			{
				$this->message('添加配置项成功','?r=systems/config',1,3);
			}else{
				$this->message('添加配置项失败','?r=systems/config',1,3);
			}
		}else{
			return $this->render('createconfig');
		}
	}
	//保存配置项
	public function actionSaveconfig()
	{
		$data = Yii::$app->request->post('data');
		foreach ($data as $k=>$v)
		{
			$configObj = new Config();
			$info = $configObj->findOne($k);
			$info->conf_order = $v['order'];
			$info->conf_content = $v['conf_content'];
			$info->save();
		}
		$configList = $configObj->find()->asArray()->all();
		$configData = [];
		foreach($configList as $key=>$val)
		{
			$configData[$val['conf_name']] = $val['conf_content'];
		}

		$this->message('更新配置项成功','?r=systems/config',1,1);

		//入配置项

	}
	//消息页面
	public function message($msg='请先登录',$url='login',$wait=1,$type=0)
	{
		$data = [
			'title'=> '提示消息',
			'msg' => $msg,
			'url' => $url,
			'wait'=> $wait,
			'type'=> $type
		];
		if ($type == 0)
		{
			$data['title'] = '错误消息';
		}
		if (empty($url))
		{
			$data['url'] = "javascript:history.back(-1);";
		}
		die( $this->renderpartial('message',$data)  );
	}

}
?>