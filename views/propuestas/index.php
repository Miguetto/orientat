<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PropuestasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Propuestas';
$this->params['breadcrumbs'][] = $this->title;

$url = Url::to(['propuestas/votos']);
$url_anular = Url::to(['propuestas/anular']);

$jsVoto = <<<EOT

        var propuestas = [];
        $(".vote").each(function(index) {
              propuestas.push($(this).attr("id"));
        });

        $.each(propuestas, function (ind, elem) { 
          
          $('#'+elem).click(function (ev) {
            ev.preventDefault();
            var id = elem.substring(5);
            
            $.ajax({
                type: 'POST',
                url: '$url',
                data: {
                    id: id,
                }
            })
            .done(function (data) {
                let numVotos = data.response;
                let id = data.propuesta_id;

                let botonVoto = $('#voto-'+data.propuesta_id);
                botonVoto.fadeOut('fast', function() {
                    botonVoto.hide();
                });

                let votoViejo = $('#votos-'+data.propuesta_id+' > span');

                let botonAnular = $('#anular-'+data.propuesta_id);
              
                botonAnular.fadeIn('fast', function() { 
                    botonAnular.show();
                });

                votoViejo.text(numVotos); 
            });
          });
        });         

EOT;

$jsAnular = <<<EOT
        var propuestas = [];
        $(".anular").each(function(index) {
            propuestas.push($(this).attr("id"));
        });

        $.each(propuestas, function (ind, elem) {
          $('#'+elem).click(function (ev) {
            ev.preventDefault();
            var id = elem.substring(7);
            $.ajax({
                type: 'POST',
                url: '$url_anular',
                data: {
                    id: id,
                }
            })
            .done(function (data) {
              let numVotos = data.response;
              let id = data.propuesta_id;
              
              let botonAnular = $('#anular-'+data.propuesta_id);
              botonAnular.fadeOut('fast', function() {
                botonAnular.hide();
              });

              let votoViejo = $('#votos-'+data.propuesta_id+' > span');

              let botonVoto = $('#voto-'+data.propuesta_id);
              
              botonVoto.fadeIn('fast', function() { 
                botonVoto.show();
              });

              votoViejo.text(numVotos);

            });
          });
        });
EOT;
$this->registerJs($jsVoto, View::POS_END);
$this->registerJs($jsAnular, View::POS_END);

?>
<div class="propuestas-index services-2 btnSuperior">
    <?php if (Yii::$app->user->identity->esAdmin || Yii::$app->user->identity->esRevisor) { ?>
        <p class="services-2">
            <?= Html::a('Crear Propuesta', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>
</div>
<section class="ftco-section ftco-no-pt ftc-no-pb">
    <div class="container">
        <div class="row">
            <div class="ftco-animate fadeInUp ftco-animated services-2">
                <h2 class="services-2"><?= Html::encode($this->title) ?></h2>
                <p class="services-2">Las propuestas pueden votarse, la que llegue a 20 votos, automáticamente un revisor la creará como recurso. ¡¡Anímate!!</p>
                    <div class="row mt-5">
                    <?php foreach ($propuestas as $propuesta) : ?>
                        <div class="col-lg-6">
                            <div class="services-2 d-flex">
                                <div class="ePropu icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span class="flaticon-education"></span></div>
                                <div class="text">
                                    <h3><?= Html::encode($propuesta->titulo) ?></h3>
                                    <p><?= Html::encode($propuesta->descripcion) ?></p>
                                    <?php if($propuesta->votos != 20 && $propuesta->usuario_id != Yii::$app->user->id ): ?>
                                        <div id="numVoto-<?= $propuesta->id ?>" class="d-flex align-items-center mt-4" style="margin-left: 05px;">
                                            <p id="votos-<?= $propuesta->id ?>">Votos: <span><?= $propuesta->votos ?></span></p>
                                        </div>
                                        <?php if($propuesta->usuario_id !== Yii::$app->user->id):?>
                                            <?php if($propuesta->existeVoto($propuesta->id) !== true) : ?>
                                                    <button type="button" id="voto-<?= $propuesta->id ?>" class="btn btn-outline-success vote"> Votar</button>
                                                    <button type="button" id="anular-<?= $propuesta->id ?>" class="btn btn-outline-danger anular" style="display: none"> Anular</button>                                        
                                                <?php else :?>
                                                    <button type="button" id="voto-<?= $propuesta->id ?>" class="btn btn-outline-success vote" style="display: none"> Votar</button>
                                                    <button type="button" id="anular-<?= $propuesta->id ?>" class="btn btn-outline-danger anular"> Anular</button>
                                            <?php endif ?>
                                        <?php endif?>
                                        <?php else:  ?>
                                            <p>Un revisor está creando el recurso, gracias por votar!!</p>
                                            <?php if($propuesta->votos != 20 && $propuesta->usuario_id == Yii::$app->user->id): ?>
                                                <p>Votos: <?=$propuesta->votos?></p>
                                                <?= Html::a('Eliminar', ['propuestas/delete', 'id' => $propuesta->id], [
                                                    'class' => 'btn btn-danger',
                                                    'data' => [
                                                    'confirm' => '¿Vas a eliminar el comentario?',
                                                    'method' => 'post',
                                                    ],
                                                ]);?>
                                            <?php endif ?>
                                    <?php endif  ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    </div>
            </div>
        </div>
    </div>
</section>