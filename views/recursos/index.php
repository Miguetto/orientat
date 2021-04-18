<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecursosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recursos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recursos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Recurso', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'titulo',
            'descripcion',
            'contenido',
            'created_at:date',
            'usuario.username:text:Creado por',
            'categoria.nombre:text:Categoría',
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
