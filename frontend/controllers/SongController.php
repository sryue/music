<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\Style;
use app\models\Languages;
use app\models\Actor;
use app\models\Music;
use app\models\AisComment;
use app\models\UploadForm;
use frontend\controllers\UploadController;
use yii\data\Pagination;
use app\models\Special;
/**
 * 歌曲模块
 */
class SongController extends CommonController
{
	#404时调用
	public $enableCsrfValidation =false;
	#禁用Yii框架的样式
	public $layout = 'comm';

	public function actionAddsong()
	{
		$data = Yii::$app->request->post();
		//上传普通音乐
		$uploadObj = new UploadController();
		$uploadObj->upload('song','./music');
		$info=  $uploadObj->get_data();
		$data['music_path'] = $info['file_path'] . '/' . $info['file_name'];

		//上传高音质
		$uploadObj->upload('songbest','./bestmusic');
		$info=  $uploadObj->get_data();
		$data['tall_music_path'] = $info['file_path'] . '/' . $info['file_name'];

		//上传歌词
		$uploadObj->upload('lyrics','./lyrics');
		$info=  $uploadObj->get_data();
		$data['lyric_path'] = $info['file_path'] . '/' . $info['file_name'];
		$data['lssue_time'] = time();

		$musicObj = new Music();
		$musicObj->style_id = $data['style_id'];
		$musicObj->actor_id = $data['actor_id'];
		$musicObj->music_name = $data['music_name'];
		$musicObj->language = $data['language'];
		$musicObj->music_img = $data['music_img'];
		$musicObj->music_path = $data['music_path'];
		$musicObj->tall_music_path = $data['tall_music_path'];
		$musicObj->lyric_path = $data['lyric_path'];
		$musicObj->lssue_time = $data['lssue_time'];
		$musicObj->spe_id        = $data['spe_id'];
		$res = $musicObj->save();
		if($res)
		{
			$this->message('添加歌曲成功','?r=song/show',1,1);
		}
	}
	//添加歌曲页面
	public function actionIndex(){

		//查询歌曲风格
		$styleObj = new Style();
		$styleList = $styleObj->find()->asArray()->all();
		//查询所有语种
		$languagesObj = new languages();
		$langList  = $languagesObj->find()->asArray()->all();
		//查询所有专辑
		$speciaObj = new Special();
		$speciList = $speciaObj->find()->asArray()->all();

		$model = new UploadForm();

		$data = ['styleList'=>$styleList,'langList'=>$langList,'speciList'=>$speciList];
		return $this->render('index',$data);
	}
	//添加表单 歌手的尾词搜索
	public function actionTailsearch()
	{
		$songer = Yii::$app->request->post('value');
		//优先查redis
        $redis = new \Redis();
        $re = $redis->connect('127.0.0.1', 6379);
        //如果连接成功 redis 没有的话查询数据库
        if($re)
        {
        	$data = $redis->keys($songer.'*');
        }else
        {
	        $actorObj = new Actor();
			$data = $actorObj->find()->where(['like','actor_name',$songer])->asArray()->all();
        }
		die(json_encode($data));
	}
	//检查演唱者是否正确
	public function actionCheckactor()
	{
		$songer = Yii::$app->request->post('songer');
		$actorObj = new Actor();
		$info = $actorObj->find()->where("actor_name = '$songer'")->asArray()->one();
		//错误返回0 正确返回歌手id
		if($info)
		{
			echo $info['actor_id'];
		}else
		{
			echo 0;
		}
	}
	//检查是否歌曲名重复
	public function actionChecksong()
	{
		$song = Yii::$app->request->post('value');
		$musicObj = new Music();
		$info = $musicObj->find()->where("music_name = '$song'")->asArray()->one();
		if($info)
		{
			echo 0;
		}else
		{
			echo 1;
		}
	}
	//歌曲列表
	public function actionShow(){
		//所有语种
		$langObj = new Languages();
		$langList = $langObj->find()->asArray()->all();
		//所有风格
		$styleObJ = new Style();
		$styleList = $styleObJ->find()->asArray()->all();
		//接收搜索条件
		$music_name = Yii::$app->request->get('music_name');
		$lang = Yii::$app->request->get('lang');
		$style_id = Yii::$app->request->get('style_id');
		$start = strtotime(Yii::$app->request->get('start'));
		$end = strtotime(Yii::$app->request->get('end'));
		$musicObj = new Music();
		$musicObj = $musicObj->find();
		//搜索条件拼接  默认值
		$formData = ['music_name'=>'','lang'=>0,'style_id'=>0,'start'=>'','end'=>''];
		if($music_name)
		{
			$musicObj = $musicObj->where(["like","music_name",$music_name]);
			$formData['music_name'] = $music_name;
		}
		if($lang!=0)
		{
			$musicObj = $musicObj->andWhere("language = $lang");
			$formData['lang'] = $lang;
		}
		if($style_id!=0)
		{
			$musicObj = $musicObj->andWhere("ais_music.style_id = $style_id");
			$formData['style_id'] = $style_id;
		}
		if(!empty($start) && !empty($end))
		{
			$musicObj = $musicObj->andWhere(['>','lssue_time',$start]);
			$musicObj = $musicObj->andWhere(['<','lssue_time',$end]);
			$formData['start'] = date('Y-m-d',$start);
			$formData['end'] = date('Y-m-d',$end);
		}
		$count = $musicObj->count();
		$pagination = new Pagination(['totalCount' => $count,'pageSize'=>10]);
		$list = $musicObj->offset($pagination->offset)->limit($pagination->limit)->select('music_id,ais_music.spe_id,music_name,lssue_time,ais_actor.actor_id,actor_name,language,ais_languages.name,music_img,music_path,download,play,ais_style.style_id,ais_style.style_name,lyric_path,ais_special.spe_name')->join('inner join','ais_actor','(ais_music.actor_id = ais_actor.actor_id)')->join('inner join','ais_languages','(ais_music.language = ais_languages.id)')->join('inner join','ais_style','(ais_music.style_id = ais_style.style_id)')->join('inner join','ais_special','(ais_music.spe_id = ais_special.spe_id)')->orderBy('lssue_time desc')->asArray()->all();
		foreach ($list as $k=>$v)
		{
			$arr = explode(',',$v['music_img']);
			$list[$k]['music_img'] = $arr[0];
		}
		return $this->render('show',['list'=>$list,'pagination'=>$pagination,'langList'=>$langList,'styleList'=>$styleList,'formData'=>$formData]);
	}
	//删除数据库记录和音乐文件 图片文件
	public function actionDelsong()
	{
		$id = Yii::$app->request->get('id');
		$musicObj = new Music();
		//删文件
		$musicList = $musicObj->find()->select('music_img,lyric_path,music_path,tall_music_path')->where("music_id = $id")->asArray()->one();
		foreach ($musicList as $k =>$v )
		{

			$arr = explode(',',$v);
			for($i=0;$i<count($arr);$i++)
			{
				 unlink('./'.$arr[$i]);
			}
		}
		//删除数据库记录
		$info  = $musicObj->findOne($id);
		$res = $info->delete();
		if($res)
		{
			$this->message('删除成功','?r=song/show',1,1);
		}else
		{
			$this->message('删除失败','?r=song/show',0,1);
		}
	}
	//试听
	public function actionListensong()
	{
		$id = Yii::$app->request->get('id');
		$musicObj = new Music();
		$musicInfo = $musicObj->find()->select('actor_name,music_name,ais_music.actor_id,music_img,music_path')->where("music_id = $id")->join('inner join','ais_actor','ais_music.actor_id = ais_actor.actor_id')->asArray()->one();

		return $this->renderPartial('listen',['music'=>$musicInfo]);
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
	//多个图片上传插件
	public function actionUploadimg()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    		exit; 
		}
		if ( !empty($_REQUEST[ 'debug' ]) ) {
		    $random = rand(0, intval($_REQUEST[ 'debug' ]) );
		    if ( $random === 0 ) {
		        header("HTTP/1.0 500 Internal Server Error");
		        exit;
		    }
		}
		@set_time_limit(5 * 60);
		usleep(5000);
		$targetDir = 'upload_tmp';
		$uploadDir = 'songUpload';
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds
		if (!file_exists($targetDir)) {
		    @mkdir($targetDir);
		}

		// Create target dir
		if (!file_exists($uploadDir)) {
		    @mkdir($uploadDir);
		}

		if (isset($_REQUEST["name"])) {
		    $fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
		    $fileName = $_FILES["file"]["name"];
		} else {
		    $fileName = uniqid("file_");
		}
		$fileName = time().substr($fileName,strrpos($fileName,'.'));
		$md5File = @file('md5list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$md5File = $md5File ? $md5File : array();

		if (isset($_REQUEST["md5"]) && array_search($_REQUEST["md5"], $md5File ) !== FALSE ) {
		    die('{"jsonrpc" : "2.0", "result" : null, "id" : "id", "exist": 1}');
		}

		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
		$uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;
		if ($cleanupTargetDir) {
		    if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
		        die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
		    }

		    while (($file = readdir($dir)) !== false) {
		        $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

		        // If temp file is current file proceed to the next
		        if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
		            continue;
		        }

		        // Remove temp file if it is older than the max age and is not the current file
		        if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
		            @unlink($tmpfilePath);
		        }
		    }
		    closedir($dir);
		}


		// Open temp file
		if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
		    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if (!empty($_FILES)) {
		    if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
		        die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		    }

		    // Read binary input stream and append it to temp file
		    if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
		        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
		    }
		} else {
		    if (!$in = @fopen("php://input", "rb")) {
		        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
		    }
		}

		while ($buff = fread($in, 4096)) {
		    fwrite($out, $buff);
		}

		@fclose($out);
		@fclose($in);

		rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

		$index = 0;
		$done = true;
		for( $index = 0; $index < $chunks; $index++ ) {
		    if ( !file_exists("{$filePath}_{$index}.part") ) {
		        $done = false;
		        break;
		    }
		}

		if ( $done ) {
		    if (!$out = @fopen($uploadPath, "wb")) {
		        die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		    }

		    if ( flock($out, LOCK_EX) ) {
		        for( $index = 0; $index < $chunks; $index++ ) {
		            if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
		                break;
		            }
		            while ($buff = fread($in, 4096)) {
		                fwrite($out, $buff);
		            }

		            @fclose($in);
		            @unlink("{$filePath}_{$index}.part");
		        }

		        flock($out, LOCK_UN);
		    }
		    @fclose($out);
		}
		$uploadPath= '/'.str_replace('\\','/',$uploadPath);
		$data = array(
				'jsonrpc'=>'2.0',
				'result' =>'null',
				'id'     => 'id',
				'imgpath'=>$uploadPath 
			);
		die(json_encode($data));
		// Return Success JSON-RPC response
		// die('{"jsonrpc" : "2.0", "result" : null, "id" : "id","imgPath":"'.$uploadPath.'"}');
	}
	//歌曲评论列表
	public function actionDiscuss(){
		$request = \Yii::$app->request;
		$search1 = $request->post("search");
		$search2 = $request->get("search");
		$search  = empty($search1) ? $search2 : $search1;
		if(!empty($search)){
			$data = AisComment::find()->select('*')
			->innerJoin('ais_music','ais_comment.music_id=ais_music.music_id')
			->innerJoin('ais_user','ais_comment.user_id=ais_user.user_id')
			->where(['like','music_name',$search]); //联查  
			// var_dump($data);die;
		}else{
			$data = AisComment::find()->select('*')
			->innerJoin('ais_music','ais_comment.music_id=ais_music.music_id')
			->innerJoin('ais_user','ais_comment.user_id=ais_user.user_id');; //联查  
			// var_dump($data);die;
       }  
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '15']);  
	        $model = $data->offset($pages->offset)->limit($pages->limit)->asArray()->all(); //分页 
	        return $this->render('discuss',[  
	             'model' => $model,  
	             'pages' => $pages,  
	             'search' =>$search,
	       ]); 
	}
	//评论删除
	public function actionDis_del(){
		$request = \Yii::$app->request;
		$id = $request->get("id");
		$search = $request->get("search");
		$customer = AisComment::findOne($id);
		$data = $customer->delete();
		if($data){
			echo "<script>alert('删除成功');location.href='?r=song/discuss&search=$search'</script>";
		}else{
			//失败
			echo "<script>alert('删除失败');history.go(-1);</script>";
		}
	}





}
?>