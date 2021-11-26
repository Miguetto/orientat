<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ButtonDropdown;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Categorias */

$this->title = 'Recursos con pdf';
$this->params['breadcrumbs'][] = ['label' => 'Categorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>


    <h1><?= Html::encode($this->title) ?></h1>
    
    
        
    <h3>
        Recursos:
        
        <?= ButtonDropdown::widget([
                'label' => 'Filtrar recursos por: ',
                'dropdown' => [
                    'items' => [
                        ['label' => 'Imágenes', 'url' => ['categorias/filtroimg']],
                        ['label' => 'PDF', 'url' => ['categorias/filtropdf']],
                        ['label' => 'Completos', 'url' => ['categorias/filtrocomp']],
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
      <?php foreach ($recursos as $recurso) : ?>
        <?php if($recurso->pdf_pdf != '') : ?>
          <div class="col-md-6 col-lg-4 ftco-animate fadeInUp ftco-animated">
            <div class="blog-entry">
              <a class="block-20 d-flex align-items-end" style="background-image: url('images/image_1.jpg');">
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
        <?php endif ?>       
      <?php endforeach ?>
    </div>
    
  </div>
</section>
