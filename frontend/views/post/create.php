<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title='新建';
$this-> params['breadcrumbs'][] = ['label' => '文章', 'url'=> ['post/index']];
$this-> params['breadcrumbs'][] = $this-> title;
?>
<div class="row">
    <div class="col-sm-9">
<!--        标题-->
        <div class="panel-title box-title">
            <span>发布文章</span>
        </div>
<!--主体-->
        <div class="panel-body">
        <?php $form = ActiveForm::begin()?>

        <?=$form->field($model,'title')->textinput(['maxlength'=>true])?>

        <?=$form->field($model,'cat_id')->dropDownList($cat)?>

        <?= $form->field($model, 'label_img')->widget('common\widgets\file_upload\FileUpload',[
            'config'=>[

            ]
        ]) ?>

        <?= $form->field($model, 'content')->widget('common\widgets\ueditor\Ueditor',[
            'options'=>[
                'initialFrameHeight' => 400,
//                'toolbars'=>[]
            ]
        ]) ?>

        <?=$form->field($model,'tags')->widget('common\widgets\tags\tagWidget'); ?>

        <div class="form-group">
            <?=Html::submitButton("发布",["class"=>'btn btn-success'])?>
        </div>

        <?php ActiveForm::End() ?>
        </div>
    </div>
    <div class="col-sm-3">
        <?=\frontend\widgets\hot\HotWidget::widget()?>
    </div>
</div>