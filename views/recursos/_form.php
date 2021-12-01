<?php


use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Recursos */
/* @var $form yii\bootstrap4\ActiveForm */

$urlTitulo = Url::to(['recursos/existe-titulo']);

$validacion = <<<EOT
    $('#recursos-titulo').blur(function (ev) {
        var titulo = $(this).val();
        $.ajax({
            type: 'GET',
            url: '$urlTitulo',
            data: {
                titulo: titulo
            }
        })
        .done(function (data) {
            if (data.find) {
                $('#titulo-v').show();
                $('#titulo-v').html('Ups!, el título ya existe.');
                $('#titulo-v').addClass('text-danger');
                $('.btn').attr("disabled","disabled");
            } else {
                $('#titulo-v').html(data.titulo);
                $('#titulo-v').hide();
                $('.btn').removeAttr("disabled");
            }
        });
    });
EOT;
$this->registerJs($validacion, View::POS_END);

?>

<div class="recursos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'img')->fileInput() ?>

    <?= $form->field($model, 'pdf')->fileInput() ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
    
    <p id="titulo-v"></p>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contenido')->textArea(['maxlength' => true, 'white-space' => 'pre-line']) ?>
    
    <?= $form->field($model, 'enlace')->textInput(['maxlength' => true]) ?>

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
