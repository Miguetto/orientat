<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Incidencias */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="incidencias-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'usuario_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

    <?= $form->field($model, 'receptor_id')->hiddenInput(['value' => Yii::$app->user->identity->findByLogin('admin')->id])->label(false) ?>

    <?= $form->field($model, 'cuerpo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    
    <?php ActiveForm::end(); ?>
</div>
