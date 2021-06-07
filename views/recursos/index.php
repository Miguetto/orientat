<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

$url = Url::to(['likes/likes', 'recurso_id' => $model->id]);

$js = <<<EOT
    $(document).ready(function () {
        $('#like' + '$model->id').click(function (e) {
          console.log($model->id);
          $('#like' + '$model->id').removeClass('far');
          $('#like' + '$model->id').addClass('fas');
        });
    });
EOT;

$this->registerJs($js);

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecursosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recursos:';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recursos-index services-2 btnSuperior">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Crear Recurso', ['create'], ['class' => 'btn btn-success', 'id' => 'e']) ?>
  </p>

</div>
<?php // echo $this->render('_search', ['model' => $searchModel]); 
?>
<section class="ftco-section bg-light">
  <div class="container">
    <div class="row">
      <?php foreach ($recursos as $recurso) : ?>
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
              <div class="d-flex align-items-center mt-4">
                <p class="mb-0">
                  <?= Html::a('Seguir leyendo', ['recursos/view', 'id' => $recurso->id], ['class' => 'btn btn-secondary', 'id' => 'seguirLeyendo']) ?>
                </p>
                <?=Html::a(null, ['likes/likes', 'recurso_id' => $recurso->id], ['class' => 'fa-heart enlace ml-2 far', 'id' => 'like'.$recurso->id])?>
                <?=$recurso->getTotalLikes()?>                
              </div>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>