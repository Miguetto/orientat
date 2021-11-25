<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Propuestas */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="propuestas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

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

    <?= $form->field($model, 'votos')->hiddenInput(['value' => 0])->label(false)?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
