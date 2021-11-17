<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\View;

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

$url = Url::to(['recursos/like']);
$url_dislike = Url::to(['recursos/dislike']);

$jsLike = <<<EOT

        var recursos = [];
        $(".liked").each(function(index) {
              recursos.push($(this).attr("id"));
        });

        $.each(recursos, function (ind, elem) { 
          console.log(ind, elem);
          $('#'+elem).click(function (ev) {
            ev.preventDefault();
            var id = elem.substring(4);
            console.log(id);
            $.ajax({
                type: 'POST',
                url: '$url',
                data: {
                    id: id,
                }
            })
            .done(function (data) {
              let p = $(data.response);
              let id = $(data.recurso_id);
              let botonDislike = $(data.boton_dislike);

              let botonLike = $('#like'+data.recurso_id);
              botonLike.fadeOut('fast', function() {
                botonLike.remove();
              });

              let likeViejo = $('#likes-'+data.recurso_id);
              likeViejo.fadeOut('fast', function() {
                  likeViejo.remove();
              });

              $('#sl').append(botonDislike);
              botonDislike.fadeIn('fast');

              $('#numlike-'+data.recurso_id).append(p);
              p.fadeIn('fast');              
          
            });
          });
        });         

EOT;

$jsDisLike = <<<EOT
        var recursos = [];
        $(".dislike").each(function(index) {
              recursos.push($(this).attr("id"));
        });

        $.each(recursos, function (ind, elem) { 
          console.log(ind, elem);
          $('#'+elem).click(function (ev) {
            ev.preventDefault();
            var id = elem.substring(7);
            console.log(id);
            $.ajax({
                type: 'POST',
                url: '$url_dislike',
                data: {
                    id: id,
                }
            })
            .done(function (data) {
              let p = $(data.response);
              let id = $(data.recurso_id);


              let likeViejo = $('#likes-'+data.recurso_id);
              likeViejo.fadeOut('fast', function() {
                  likeViejo.remove();
              });

              $('#numlike-'+data.recurso_id).appendChild(p);
              p.fadeIn('fast');
              
            });
          });
        });
EOT;
$this->registerJs($jsLike, View::POS_END);
$this->registerJs($jsDisLike, View::POS_END);


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
              <div id="sl" class="d-flex align-items-center mt-4">
                <p class="mb-0">
                  <?= Html::a('Seguir leyendo', ['recursos/view', 'id' => $recurso->id], ['class' => 'btn btn-secondary', 'id' => 'seguirLeyendo']) ?>
                </p>
                <?php if($recurso->usuario_id !== Yii::$app->user->id):?>
                  <?php if($recurso->existeLike($recurso->id) !== true) : ?>
                    <button type="button" id="like<?= $recurso->id ?>" class="btn btn-success btn-sm liked"><em class="far fa-thumbs-up"></em> Like</button>
                  <?php else :?>
                    <button type="button" id="dislike<?= $recurso->id ?>" class="btn btn-default btn-sm dislike"><em class="far fa-thumbs-down"></em> Dislike</button>
                  <?php endif ?>
                <?php endif?>
                <div id="numlike-<?= $recurso->id ?>" class="d-flex align-items-center mt-4"><p id="likes-<?= $recurso->id ?>">Likes: <?= $recurso->likes ?></p></div>             
              </div>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>