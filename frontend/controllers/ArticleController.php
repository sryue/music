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
            'pageSize'   => '15'  //每页显示条数
        ]);
        $arr = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render("show",['data'=>$arr,'where'=>$where,'pages'=>$pages]);
	}


	//删除
	public function actionDel(){
		//接收值
		$request = \Yii::$app->request;
		$id = $request->post("id");
	
		//删除操作
		$modelObj = AisArticle::findOne($id);
		//获取图片名称
		$file = $modelObj['art_img'];
		$data = $modelObj->delete();

		//图片路径
		$link = './instyle/images/article/'.$file;
		if($data){
			if (!empty($file)) {
				unlink($link);
			}
			echo "1";
		}else
			echo "0";
	}



	public function actionCurls_add($url){
		/*
		*大众网
		 */
		//1.初始化，创建一个新cURL资源
		$curl = curl_init();
		//2.设置URL和相应的选项
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息 
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		//3.抓取URL并把它传递给浏览器
		return  curl_exec($curl);
	}
	public function actionCurls(){
		//旋转时间位100秒
		ini_set("max_execution_time",'100');
		//网站路径
		$url = "http://news.yule.com.cn/music/index.html";
		$html = $this->actionCurls_add($url);
		$reg1 = '#<div id="theContent">.*</div>#is';
		preg_match($reg1,$html,$arr1);
		$reg2 = '#<div class=".*">.*<div class=".*"><span class=".*"> <a href="(.*)" title=".*">(.*)</a></span></div><div class=".*"><span class=".*">(.*)</span></div><div class=".*">.*</div>
			</div>#isU';
		preg_match_all($reg2,$arr1[0],$arr2,PREG_SET_ORDER);
		// var_dump($arr2);die;

		for ($i=0; $i <count($arr2);$i++) { 

			for ($j=0; $j<count($arr2[$i]); $j++) { 
				$date['art_title'] = $arr2[$i][2];
				$date['art_starttime'] = $arr2[$i][3];
				$htmls = $this->actionCurls_add($arr2[$i][1]);
				$reg3 = '#<div id="NewsContentLabel" class="NewsContent">(.*)<div id="thePage"></div>#isU';
				preg_match($reg3,$htmls,$arr3);
				// var_dump($arr3[1]);die;
				$date['art_content'] = $arr3[1];      //内容取出来

				


			}
			////实例化M
			$modelObj = new AisArticle();
				foreach ($date as $key => $val) {
					$modelObj->$key =$val;
				}
				$ar = $modelObj->save();

		}

		

	}


}
?>