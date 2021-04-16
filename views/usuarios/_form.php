<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

    <?php
        // Solo el admin puede cambiar el rol.
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->esAdmin == true){ ?>
            <?= $form->field($model, 'rol_id')->dropdownList($roles) ?>
        <?php }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Registrarse', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
