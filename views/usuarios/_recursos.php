<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecursosSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="recursos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['herramientas'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'titulo')
             ->textInput([
                'placeholder' => 'Busqueda por título',
                'class' => 'form-style form-control'
             ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Limpiar', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>