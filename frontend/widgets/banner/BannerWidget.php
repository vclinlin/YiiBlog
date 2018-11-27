<?php
/**
 * Created by PhpStorm.
 * User: 17424
 * Date: 2018/5/20
 * Time: 17:36
 */
namespace  frontend\widgets\banner;

use Yii;
use yii\bootstrap\Widget;

class BannerWidget extends Widget
{
    public $items = [];

    public function init()
    {
        if(empty($this->items)){
            $this->items=[
                [
                    'label'=>'demo',
                    'image_url'=>'/static/images/lunbo/lunbo01.jpg',
                    'url'=>['site/index'],
                    'html'=>'',
                    'active'=>'active',
                ],
                ['label'=>'demo','image_url'=>'/static/images/lunbo/lunbo02.jpg','url'=>['site/index'],'html'=>'',],
                ['label'=>'demo','image_url'=>'/static/images/lunbo/lunbo03.jpg','url'=>['site/index'],'html'=>'',],
                ['label'=>'demo','image_url'=>'/static/images/lunbo/lunbo04.jpg','url'=>['site/index'],'html'=>'',],
                ['label'=>'demo','image_url'=>'/static/images/lunbo/lunbo05.jpg','url'=>['site/index'],'html'=>'',],
                ['label'=>'demo','image_url'=>'/static/images/lunbo/lunbo06.jpg','url'=>['site/index'],'html'=>'',],
            ];
        }

    }
    public function run()
    {
        $data['items'] = $this->items;
        return $this->render('index',['data'=>$data]);
    }
}