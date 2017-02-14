<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * 主页
 */
class CommonController extends Controller
{
    #404时调用
    public $enableCsrfValidation =false;
    #禁用Yii框架的样式
    public $layout = 'comm';

    public function init(){
//        $session = Yii::$app->session;
//        $session->open();
//        $name=$session->get('name');
//        if($name==""){
//            echo "<script> alert('请先登录');window.location.href='?r=login/index';</script>";
//        }
    }
}
?>