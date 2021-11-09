<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RespuestasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Respuestas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="respuestas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Respuestas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'cuerpo',
            'created_at',
            'comentario_id',
            'usuario_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
