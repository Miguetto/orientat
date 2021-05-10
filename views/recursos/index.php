<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecursosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recursos:';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recursos-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Crear Recurso', ['create'], ['class' => 'btn btn-success']) ?>
  </p>

</div>
<?php // echo $this->render('_search', ['model' => $searchModel]); 
?>
<section class="ftco-section bg-light">
  <div class="container">
    <div class="row">
      <?php foreach ($recursos as $recurso) : ?>
        <div class="col-md-6 col-lg-4">
          <div class="blog-entry">
            <a class="block-20 d-flex align-items-end" style="background-image: url('images/image_1.jpg');">
              <div class="meta-date text-center p-2">
                <span class="day"><?= Yii::$app->formatter->asDate($recurso->created_at, 'long') ?></span>
              </div>
            </a>
            <div class="text bg-white p-4">
              <h3 class="heading"><?= Html::a($recurso->titulo, ['recursos/view', 'id' => $recurso->id]) ?></h3>
              <p><?= $recurso->descripcion; ?></p>
              <div class="d-flex align-items-center mt-4">
                <p class="mb-0">
                  <?= Html::a('Seguir leyendo', ['recursos/view', 'id' => $recurso->id], ['class' => 'btn btn-secondary']) ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>