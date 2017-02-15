<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\languages;
use app\models\style;
use app\models\Special;
use frontend\controllers\UploadController;
use yii\data\Pagination;
use frontend\controllers\SongController;
/**
 * 专辑模块
 */
class SpecialController extends Controller
{
	#404时调用
	public $enableCsrfValidation =false;
	#禁用Yii框架的样式
	public $layout = "comm";

	public function actionIndex()
    {
        $language = $this->actionGetlanguage();
//        print_r($language);die;
		return $this->render('index',['info'=>$language]);
	}
    /**
     * 获取风格，语言信息
     *
     * @return array
     */
    public function actionGetlanguage()
    {
        $language = new languages();
        $style = new style();
        return ['language'=>$language::find()->asArray()->all(),'style'=>$style::find()->asArray()->all()];
    }

	/**
     * 专辑添加
     *
     * @return view
     */
    public function  actionSpe_add()
    {
        $upload = new UploadController();
        $res = $upload->upload('spe_img');
        if($res)
        {
            $img_info = $upload->get_data();
            $info = \Yii::$app->request->post();
            unset($info['actor_name']);
            $info['spe_img'] = $img_info['file_path'].'/'.$img_info['file_name'];
//            print_r($info);die;

            $special = new Special();
            foreach($info as $k => $v)
            {
                $special->$k = $v;
            }
            if($special->save())
            {
                echo "<script>alert('添加成功');location.href='?r=special/spe_list'</script>";
            }
            else
            {
                echo "<script>alert('添加失败');history.go(-1)</script>";
            }
        }
        else{
            echo "<script>alert('".$upload->get_error()."');history.go(-1)</script>";
        }
    }
    /**
     * 专辑列表
     *
     * @return view
     */
    public function actionSpe_list()
    {
        $spe_name = \Yii::$app->request->get('spe_name');
        $special = new Special();
        $spe_info = $special->find();
        if(isset($spe_name) && !empty($spe_name))
        {
            $spe_info = $special->find()->where("spe_name like '%$spe_name%'");
        }
        $pages = new Pagination(['totalCount' => $spe_info->count()]);
        $models = $spe_info->offset($pages->offset)
            ->limit($pages->limit)->select('*')
            ->Join('inner join','ais_languages','(ais_special.spe_language=ais_languages.id)')
            ->Join('inner join','ais_style','(ais_special.spe_style=ais_style.style_id)')
            ->Join('inner join','ais_actor','(ais_special.actor_id=ais_actor.actor_id)')
            ->asArray()->all();;
        return $this->render('spe_list',['models'=>$models,'pages'=>$pages]);
    }

    /**
     * 专辑删除
     * @return string
     */
    public function actionDel_spe()
    {
        $spe_id = \Yii::$app->request->get('spe_id');
        $special = new Special();
        $spe_info = $special::find()->where(['spe_id'=>$spe_id])->asArray()->one();
        if(isset($spe_info) && !empty($spe_info))
        {
            @unlink($spe_info['spe_img']);
            $res = $special::deleteAll('spe_id=:id',[':id'=>$spe_id]);
            if($res)
            {
                echo 1;
            }
            else
            {
                echo 0;
            }
        }
        else
        {
            echo 2;
        }
    }
    /**
     * 专辑修改
     * @return string
     */
    public function actionUpd_spe()
    {
        $spe_name = \Yii::$app->request->get('spe_name');
        $spe_id = \Yii::$app->request->get('spe_id');
        $special = new Special();
        $actor_obj = $special::updateAll(['spe_name' => $spe_name] , ['spe_id' => $spe_id]);
        if($actor_obj)
        {
            echo 1;
        }
        else
        {
            echo 2;
        }

    }


}
?>