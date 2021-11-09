<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Respuestas */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="respuestas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cuerpo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comentario_id')->hiddenInput(['value' => $comentario_id])->label(false) ?>
    
    <?= $form->field($model, 'usuario_id')->hiddenInput(['value' => $usuario_id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
