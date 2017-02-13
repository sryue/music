<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\AisArticle;
use yii\web\UploadedFile;
use yii\data\Pagination;
/**
 * 管理员模块
 */
class ArticleController extends Controller
{
	#404时调用
	public $enableCsrfValidation =false;
	#禁用Yii框架的样式
	public $layout = 'comm';

	public function actionIndex(){
		return $this->render('index');
	}
	public function actionIndex_add(){
		//实例化M
		$modelObj = new AisArticle();
		//接收post值
		$request = \Yii::$app->request;
		//判断是不是图片接收
		if($request->isPost){
			//接收图片的信息值
			$image = UploadedFile::getInstanceByName('art_img');
			//打印看看 有接着做没有换另一种方法  var_dump($images);die;
			//上传目录，进行命名
			$dir = Yii::$app->request->hostInfo;
			$dir = './instyle/images/article/';
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
				$modelObj->art_img=$names;

				//调用model层attributes方法，将post接值数据一起（这是将表单中的其他值接受过来，一起入库使的）
				$modelObj->attributes = $request->post();
				$data = $modelObj->save();
				if($data){
					//成功	
					 echo "<script>alert('添加成功');location.href='?r=article/show'</script>";
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

	public function actionShow(){
		
		//接收值
		$where = Yii::$app->request->get();
        $query = new \yii\db\Query();
        $query->from('ais_article');
         //判断where条件
        if(!empty($where['title'])){
            $query->andFilterWhere(['like','art_title',$where['title']]);
        }
        if(!empty($where['content'])){
            $query->andWhere(['like','art_content',$where['content']]);
        }
        $data = $query->from('ais_article')->all();
        // return $this->render('show',['data'=>$data]);
        $pages = new  Pagination([
            //'totalCount' => $countQuery->count(),
            'totalCount' => $query->count(),
            'pageSize'   => '2'  //每页显示条数
        ]);
        $arr = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render("show",['data'=>$arr,'where'=>$where,'pages'=>$pages]);
	}


}
?>