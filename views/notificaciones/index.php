<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NotificacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notificaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notificaciones-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Notificación', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'visto:boolean',
                'cuerpo',
                [
                    '__class' => ActionColumn::class,
                    'template' => '{ver}',
                    'buttons' => [
                        'ver' => function ($url, $model) {
                            return Html::a(
                                'Ver',
                                [
                                    'notificaciones/visto',
                                    'id' => $model->recurso_id,
                                ],
                                [
                                    'class' => 'btn btn-sm btn-primary',
                                    'data-method' => 'POST',
                                ],
                            );
                        },
                    ]
                ],
                //['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
</div>
