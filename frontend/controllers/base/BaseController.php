<?php
/**
 * Created by PhpStorm.
 * User: 17424
 * Date: 2018/5/19
 * Time: 22:18

 基础控制器
 */
namespace frontend\controllers\base;


use yii\web\Controller;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if(!parent::beforeAction($action)){
            return false;
        }
        return true;
    }
}