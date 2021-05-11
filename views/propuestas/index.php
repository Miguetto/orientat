<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PropuestasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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
                                <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span class="flaticon-education"></span></div>
                                <div class="text">
                                    <h3><?= Html::encode($propuesta->titulo) ?></h3>
                                    <p><?= Html::encode($propuesta->descripcion) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    </div>
            </div>
        </div>
    </div>
</section>