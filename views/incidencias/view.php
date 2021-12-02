<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Incidencias */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Incidencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="incidencias-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Volver', ['index'], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{summary}\n{items}\n<div class='d-flex justify-content-center'>{pager}</div>",
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
                    return $model->usuario->username;
                },
            ],
            'visto:boolean',
            'cuerpo',
            ],
            'options' => [
                'class' => 'table table-responsive',
            ]
    ]); ?>
</div>
