<?php

use yii\bootstrap4\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Recursos */
/* @var $form yii\bootstrap4\ActiveForm */

?>

<div class="recursos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'img')->fileInput() ?>

    <?= $form->field($model, 'pdf')->fileInput() ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'enlace')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'contenido')->textArea(['white-space' => 'pre-line']); ?>
    
    <?php
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->esAdmin == true){ ?>
            <?= $form->field($model, 'usuario_id')->dropdownList($usuarios) ?>
        <?php } else { ?>
        <?= 
            $form->field($model, 'usuario_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false)
        ?>
    <?php
    }
    ?>

    <?= $form->field($model, 'likes')->hiddenInput(['value' => 0])->label(false)?>

    <?= $form->field($model, 'categoria_id')->dropdownList($categorias) ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
