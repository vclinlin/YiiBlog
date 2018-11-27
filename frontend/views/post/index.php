<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Widget;
$this->title = '文章';

?>
<div class="row">
    <div class="col-sm-9">
<!--        文章列表-->
    <?=\frontend\widgets\post\PostWidget::widget(['limit'=>4,'page'=>true])?>
    </div>
    <div class="col-sm-3">
<!--        热门-->
    <?=\frontend\widgets\hot\HotWidget::widget()?>
    </div>
</div>
