<?php

use app\components\Utilidad;
use yii\bootstrap4\Html;
use yii\bootstrap4\ButtonDropdown;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Categorias */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Categorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>


    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
    <?php
    if (Yii::$app->user->identity->esAdmin || Yii::$app->user->identity->esRevisor) : ?>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Vas a eliminarlo?',
                'method' => 'post',
            ],
        ]) ?>
    
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
        ],
    ]) ?>
    <?php endif ?>
        
    <h3>
        Recursos:
        
        <?= ButtonDropdown::widget([
                'label' => 'Filtrar recursos por: ',
                'dropdown' => [
                    'items' => [
                        ['label' => 'Imágenes', 'url' => ['categorias/filtroimg', 'id' =>$model->id]],
                        ['label' => 'PDF', 'url' => ['categorias/filtropdf', 'id' =>$model->id]],
                        ['label' => 'Completos', 'url' => ['categorias/filtrocomp', 'id' =>$model->id]],
                        ['label' => 'Volver', 'url' => ['categorias/index']],
                    ],
                ],
                'options' => [
                    'class' => 'btn btn-warning btn-sm float-right',
                ]
        ]);?>
        
    </h3>

<section class="ftco-section bg-light">
  <div class="container">
    <div class="row">
        <?php if($recursos != null) : ?>
      <?php foreach ($recursos as $recurso) : ?>
            <div class="col-md-6 col-lg-4 ftco-animate fadeInUp ftco-animated">
          <div class="blog-entry">
            <a class="block-20 d-flex align-items-end" style="background-image: url('<?= $recurso->getImagen(); ?>');">
              <div class="meta-date text-center p-2">
                <span class="day"><?= Yii::$app->formatter->asDate($recurso->created_at, 'long') ?></span>
              </div>
            </a>
            <div class="text bg-white p-4">
              <h3 class="heading"><?= Html::a($recurso->titulo, ['recursos/view', 'id' => $recurso->id]) ?></h3>
              <p><?= $recurso->descripcion; ?></p>
              <div id="sl<?= $recurso->id ?>" class="d-flex align-items-center mt-4">
                <p class="mb-0" style="margin-right: 05px;">
                  <?= Html::a('Seguir leyendo', ['recursos/view', 'id' => $recurso->id], ['class' => 'btn btn-secondary', 'id' => 'seguirLeyendo']) ?>
                </p>             
              </div>
            </div>
          </div>
        </div>       
      <?php endforeach ?>
    </div>
    <?php else : ?>
        <p>No se encontraron resultados.</p>
    <?php endif ?>
</section>