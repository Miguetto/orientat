<?php


use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PropuestasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$jsEvoto = <<<EOT
     
EOT;
$this->registerJs($jsEvoto, View::POS_END);

$this->title = 'Propuestas';
$this->params['breadcrumbs'][] = $this->title;
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
                                    <?php if($propuesta->getTotalVotos() != 20 && $propuesta->usuario_id != Yii::$app->user->id ): ?>
                                        <?=Html::a('Votar', ['votos/votos', 'propuesta_id' => $propuesta->id, 'titulo' => $propuesta->titulo, 'revisor' => $propuesta->usuario_id], ['class' => 'btn btn-outline-secondary', 'id' => 'voto'.$propuesta->id])?>
                                        <?=$propuesta->getTotalVotos()?>
                                        <?php else:  ?>
                                            <?=Html::a('Votar', ['votos/votos', 'propuesta_id' => $propuesta->id], ['style' => 'display: none;', 'class' => 'btn btn-outline-secondary', 'id' => 'voto'.$propuesta->id])?>
                                            <p>Un revisor está creando el recurso, gracias por votar!!</p>
                                            <?php if($propuesta->getTotalVotos() != 20 && $propuesta->usuario_id == Yii::$app->user->id): ?>
                                                <p>Votos: <?=$propuesta->getTotalVotos()?></p>
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