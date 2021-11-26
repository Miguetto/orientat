<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\LinkPager;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Administración';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="usuarios-index">

    <h3>Usuarios:</h3>
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{summary}\n{items}\n<div class='d-flex justify-content-center'>{pager}</div>",
        'columns' => [

            'id',
            'nombre',
            'username',
            'email:email',
            'rol.rol',
            'de_baja:boolean',
            'created_at',
            [
                '__class' => ActionColumn::class,
                'template' => '{ver}{modificar}{eliminar}',
                'buttons' => [
                    'ver' => function ($url, $model) {
                        return Html::a(
                            'Ver',
                            [
                                'usuarios/view',
                                'id' => $model->id,
                            ],
                            [
                                'class' => 'btn btn-sm btn-primary',
                                'data-method' => 'POST',
                            ],
                        );
                    },
                    'modificar' => function ($url, $model) {
                        if(Yii::$app->user->identity->esAdmin || Yii::$app->user->identity->esRevisor){
                            return Html::a(
                                'Modificar',
                                [
                                    'usuarios/update',
                                    'id' => $model->id,
                                ],
                                [
                                    'class' => 'btn btn-sm btn-secondary',
                                    'data-method' => 'POST',
                                ],
                            );
                        }
                    },
                    'eliminar' => function ($url, $model) {
                        if(Yii::$app->user->identity->esAdmin || Yii::$app->user->identity->esRevisor){
                            return Html::a(
                                'Eliminar',
                                [
                                    'usuarios/delete',
                                    'id' => $model->id,
                                ],
                                [
                                    'class' => 'btn btn-sm btn-danger',
                                    'data-method' => 'POST',
                                ],
                            );
                        }
                    }
                ]
            ],
        ],
        'options' => [
            'class' => 'table table-responsive',
            'id' => 'usuarios-tabla'
        ]
    ]); ?>

<div class="recursos-index">

<h3>Recursos:</h3>
<?= $this->render('_recursos', ['model' => $searchModel2]); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider2,
    'layout' => "{summary}\n{items}\n<div class='d-flex justify-content-center'>{pager}</div>",
    'columns' => [

        'id',
        'titulo',
        [
            'attribute' => 'usuario_id',
            'value' => function ($model) {
                return $model->usuario->username;
            },
        ],
        'created_at',
        [
            '__class' => ActionColumn::class,
            'template' => '{ver}{modificar}{eliminar}',
            'buttons' => [
                'ver' => function ($url, $model) {
                    return Html::a(
                        'Ver',
                        [
                            'recursos/view',
                            'id' => $model->id,
                        ],
                        [
                            'class' => 'btn btn-sm btn-primary',
                            'data-method' => 'POST',
                        ],
                    );
                },
                'modificar' => function ($url, $model) {
                    if(Yii::$app->user->identity->esAdmin || Yii::$app->user->identity->esRevisor){
                        return Html::a(
                            'Modificar',
                            [
                                'recursos/update',
                                'id' => $model->id,
                            ],
                            [
                                'class' => 'btn btn-sm btn-secondary',
                                'data-method' => 'POST',
                            ],
                        );
                    }
                },
                'eliminar' => function ($url, $model) {
                    if(Yii::$app->user->identity->esAdmin || Yii::$app->user->identity->esRevisor){
                        return Html::a(
                            'Eliminar',
                            [
                                'recursos/delete',
                                'id' => $model->id,
                            ],
                            [
                                'class' => 'btn btn-sm btn-danger',
                                'data-method' => 'POST',
                            ],
                        );
                    }
                }
            ]
        ],
        //['class' => 'yii\grid\ActionColumn'],
    ],
    'options' => [
        'class' => 'table table-responsive',
    ]
]); ?>
</div>

</div>