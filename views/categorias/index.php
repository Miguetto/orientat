<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categorias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorias-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear categoría', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'nombre',
            [
                '__class' => ActionColumn::class,
                'template' => '{ver}{modificar}{eliminar}',
                'buttons' => [
                    'ver' => function ($url, $model) {
                        return Html::a(
                            'Ver',
                            [
                                'categorias/view',
                                'id' => $model->id,
                            ],
                            [
                                'class' => 'btn btn-sm btn-primary',
                                'style' => 'margin-right: 5px',
                                'data-method' => 'POST',
                            ],
                        );
                    },
                    'modificar' => function ($url, $model) {
                        if(Yii::$app->user->identity->esAdmin || Yii::$app->user->identity->esRevisor){
                            return Html::a(
                                'Modificar',
                                [
                                    'categorias/update',
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
                        if(Yii::$app->user->identity->esAdmin || Yii::$app->user->identity->esRevisor){
                            return Html::a(
                                'Eliminar',
                                [
                                    'categorias/delete',
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
