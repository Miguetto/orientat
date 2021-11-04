<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Comentarios */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="comentarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cuerpo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recurso_id')->hiddenInput(['value' => $recurso_id])->label(false) ?>

    <?= $form->field($model, 'usuario_id')->hiddenInput(['value' => $usuario_id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
