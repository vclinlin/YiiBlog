<?php

/* @var $this yii\web\View */
use yii\base\Widget;
use yii\helpers\Url;
$this->title = '知否丶';
?>
<div class="row">
        <div class="col-sm-9">
        <!--        轮播图片-->
        <?=\frontend\widgets\banner\BannerWidget::widget()?>

        </div>
        <div class="col-sm-3">
            <?=\frontend\widgets\chat\ChatWidget::widget()?>
        </div>
</div>
<div class="row">
    <div class="col-sm-9">
        <!--        文章列表-->
        <?=\frontend\widgets\post\PostWidget::widget(['limit'=>4,'page'=>true])?>
    </div>
    <div class="col-sm-3">
        <?=\frontend\widgets\hot\HotWidget::widget()?>
        <div class="panel">
            <?php if(!\Yii::$app->user->isGuest):?>
                <a class="btn btn-success btn-block btn-post" href="<?=Url::to(['post/create'])?>">创建文章</a>
            <?php endif;?>
        </div>
    </div>
</div>



