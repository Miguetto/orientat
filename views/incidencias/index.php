<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IncidenciasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Incidencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incidencias-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear incidencia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            [
                'attribute' => 'Creador',
                'value' => function ($model) {
                    return $model->usuario->username;
                },
            ],
            [
                'attribute' => 'Receptor',
                'value' => function ($model) {
                    return $model->receptor->username;
                },
            ],
            'visto:boolean',
            'cuerpo',

            [
                '__class' => ActionColumn::class,
                'template' => '{ver}{modificar}{eliminar}',
                'buttons' => [
                    'ver' => function ($url, $model) {
                        if(Yii::$app->user->identity->esAdmin){
                            return Html::a(
                                'Ver',
                                [
                                    'incidencias/visto',
                                    'id' => $model->id,
                                ],
                                [
                                    'class' => 'btn btn-sm btn-primary',
                                    'style' => 'margin-right: 5px',
                                    'data-method' => 'POST',
                                ],
                            );
                        }
                    },
                    'modificar' => function ($url, $model) {
                        if(Yii::$app->user->identity->esAdmin || Yii::$app->user->identity->id == $model->usuario_id){
                            return Html::a(
                                'Modificar',
                                [
                                    'incidencias/update',
                                    'id' => $model->id,
                                ],
                                [
                                    'class' => 'btn btn-sm btn-secondary',
                                    'style' => 'margin-right: 5px',
                                    'data-method' => 'POST',
                                ],
                            );
                        }
                    },
                    'eliminar' => function ($url, $model) {
                        if(Yii::$app->user->identity->esAdmin || Yii::$app->user->identity->id == $model->usuario_id){
                            return Html::a(
                                'Eliminar',
                                [
                                    'incidencias/delete',
                                    'id' => $model->id,
                                ],
                                [
                                    'class' => 'btn btn-sm btn-danger',
                                    'data-method' => 'POST',
                                ],
                            );
                        }
                    },
                ]
            ],
        ],
    ]); ?>


</div>
