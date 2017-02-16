<?php
namespace frontend\controllers;

use Yii;

use yii\web\Controller;
use frontend\models\Areas;
use app\models\Actor;
use frontend\controllers\UploadController;
use yii\data\Pagination;
/**
 * 艺人模块
 */
class ActorController extends Controller
{
	#404时调用
	public $enableCsrfValidation =false;
	#禁用Yii框架的样式
	public $layout = "comm";

	public function actionIndex()
    {
		return $this->render('index');
	}

    /**
     * 艺人添加
     *
     * @view addactor
     */
	public function actionAddactor()
    {
        $areaInfo = $this->actionGetarea();
        return $this->render('addactor',['area_info'=>$areaInfo]);
    }
    public function actionAddactor_do()
    {
        $upload = new UploadController();
        $res = $upload->upload('actor_img');
//        var_dump($res);die;
        if($res)
        {
            $img_info = $upload->get_data();
            $info = \Yii::$app->request->post();
            $reg_info = serialize($info['region']);
            $info['region'] = $reg_info;
            $info['actor_img'] = $img_info['file_path'].'/'.$img_info['file_name'];

//            $redis = new \redis();
//            $result = $redis->connect('127.0.0.1', 6379);
//
//
//            $res = $redis->set('music_info',$info);

            $actor = new Actor();
            foreach($info as $k => $v)
            {
                $actor->$k = $v;
            }
            if($actor->save())
            {
                echo "<script>alert('添加成功');history.go(-1);</script>";
            }
            else
                {
                     echo "<script>alert('添加失败');history.go(-1);</script>";
                }
        }
    }
    /**
     *  艺人列表
     * @view
     */
    public function actionActorshow()
    {
        $actor = new Actor();
        $actor_name = \Yii::$app->request->get('actor_name');

        if(isset($actor_name) && !empty($actor_name))
        {
            $info = $actor::find()->where("actor_name like '%$actor_name%'");
        }
        else
        {
            $info = $actor::find();
        }
//        print_r($info);die;
        $pages = new Pagination(['totalCount' => $info->count()]);
        $models = $info->offset($pages->offset)
            ->limit($pages->limit);
        $info = $models->asArray()->all();


        if(isset($info) && !empty($info))
        {
            $areas = new Areas();
            foreach($info as $k => $v)
            {
                $reg_id = unserialize($v['region']);
                $region = '';
                if(isset($reg_id) && !empty($reg_id))
                {
                    foreach($reg_id as $key => $val)
                    {
                        $reg_info = $areas::find()->where(['area_id'=>$val])->asArray()->one();
                        $region .= '-'.$reg_info['area_name'];
                    }
                    $info[$k]['region'] =trim($region,"-");
                }
                else
                    {
                        $info[$k]['region'] ='';
                    }

            }
        }
        return $this->render('actorshow',['actor_info'=>$info,'pages'=>$pages]);
    }

    /**
     * 删除操作
     * @return string
     */
    public function actionDelete_actor()
    {
        $actor_id = \Yii::$app->request->get('actor_id');
        $actor = new Actor();
        $res = $actor::deleteAll('actor_id=:id',[':id'=>$actor_id]);
        if($res)
        {
            echo 1;
        }
        else
        {
            echo 2;
        }
    }
    /**
     * 修改操作
     * @return json
     */
    public function actionActor_update()
    {
        $actor_info = \Yii::$app->request->get();
        $actor = new Actor();
        $actor_obj = $actor::updateAll(['actor_name' => $actor_info['actor_name']] , ['actor_id' => $actor_info['actor_id']]);
        if($actor_obj)
        {
            echo 1;
        }
        else
            {
                echo 2;
            }
    }


    /**
     * 三级城市联动
     * @return array
     */
    public function actionGetarea()
    {
        $areaObj = new Areas();
        $areaInfo = $areaObj->Getarea(['parent_id'=>0])->asArray()->all();
        return $areaInfo;
    }
    /**
     * 三级城市联动
     *
     * @return json
     */
    public function actionGet_area()
    {
        $parent_id = \Yii::$app->request->get('parent_id');
        $areaObj = new Areas();
        $areaInfo = $areaObj->Getarea(['parent_id'=>$parent_id])->asArray()->all();
        return json_encode($areaInfo);
    }
}
?>