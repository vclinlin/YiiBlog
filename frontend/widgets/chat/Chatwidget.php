<?php
/**
 * Created by PhpStorm.
 * User: 17424
 * Date: 2018/5/20
 * Time: 18:35
 */
namespace frontend\widgets\chat;

use frontend\models\FeedForm;
use yii\bootstrap\Widget;

/**
 * Class Chatwidget
 * @package frontend\widgets\chat
 * 留言
 */
class ChatWidget extends Widget
{
    public function run()
    {
        $feed = new FeedForm();
        $data['feed'] = $feed->getList();
        return $this->render('index',['data'=>$data]);
    }
}