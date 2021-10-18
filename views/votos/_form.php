<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Votos */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="votos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'puntuacion')->textInput() ?>

    <?= $form->field($model, 'usuario_id')->textInput() ?>

    <?= $form->field($model, 'propuesta_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
