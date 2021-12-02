<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\bootstrap4\ActiveForm */

$urlUsuario = Url::to(['usuarios/existe-username']);

$validacion = <<<EOT
    $('#usuarios-username').blur(function (ev) {
        var username = $(this).val();
        $.ajax({
            type: 'GET',
            url: '$urlUsuario',
            data: {
                username: username
            }
        })
        .done(function (data) {
            if (data.find) {
                $('#username-v').show();
                $('#username-v').html('Ups!, el username ya existe.');
                $('#username-v').addClass('text-danger');
                $('.btn').attr("disabled","disabled");
            } else {
                $('#username-v').html(data.usuario);
                $('#username-v').hide();
                $('.btn').removeAttr("disabled");
            }
        });
    });        
EOT;
$this->registerJs($validacion, View::POS_END);

?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <p id="username-v"></p>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

    <?php
        // Solo el admin puede cambiar el rol.
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->esAdmin == true){ ?>
            <?= $form->field($model, 'rol_id')->dropdownList($roles) ?>
        <?php }
    ?>

    <?= $form->field($model, 'notificacion_id')->hiddenInput(['value' => null])->label(false)?>

    <div class="form-group">
        <?= Html::submitButton('Registrarse', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
