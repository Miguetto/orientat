<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Recursos */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Recursos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <p>
                <?php
                if (Yii::$app->user->identity->esAdmin || Yii::$app->user->identity->esRevisor) { ?>
                    <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => '¿Vas a eliminarlo?',
                            'method' => 'post',
                        ],
                ]) ?><?php } ?>
                </p>
                <h2 class="section-heading"><?= Html::encode($model->titulo) ?></h2>
                <blockquote class="blockquote"><?= Html::encode($model->descripcion) ?></blockquote>
                <p class="contenidoRecurso"><?= Html::encode($model->contenido) ?></p>
                <p class="contenidoRecurso">
                    <?= Html::a('Ir al enlace', Url::to($model->enlace), ['class' => 'btn btn-info']) ?>
                </p>
                <div class="p-0 text-center">
                    <?= Html::img($model->getImagen(), ['class' => 'img-fluid', 'id' => 'img', 'itemprop' => 'image']) ?>
                </div>
                <?php if($model->pdf_pdf != null){ ?>
                    <p class="p-0 text-center">Descarga el pdf del recurso:</p>
                    <div class="p-0 text-center">
                        <?= Html::a('Descargar PDF', [
                                'recursos/pdf',
                                'id' => $model->id,
                            ], [
                                'class' => 'btn btn-secondary',
                                'target' => '_blank',
                            ]);
                    }else {} ?>
                </div>                
            </div>
        </div>
    </div>
</article>