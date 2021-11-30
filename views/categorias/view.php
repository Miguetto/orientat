<?php

use app\components\Utilidad;
use yii\bootstrap4\Html;
use yii\bootstrap4\ButtonDropdown;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Categorias */

$this->title = $categoria->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Categorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>


    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
    <?php
    if (Yii::$app->user->identity->esAdmin || Yii::$app->user->identity->esRevisor) : ?>
        <?= Html::a('Modificar', ['update', 'id' => $categoria->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $categoria->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Vas a eliminarlo?',
                'method' => 'post',
            ],
        ]) ?>
    
    </p>

    <?= DetailView::widget([
        'model' => $categoria,
        'attributes' => [
            'id',
            'nombre',
        ],
    ]) ?>
    <?php endif ?>
        
    <h3>
        <?= $this->render('_recursosSearch', ['model' => $searchModel, 'id' => $categoria->id]); ?>
        Recursos:
                
        <?= ButtonDropdown::widget([
                'label' => 'Filtrar recursos por: ',
                'dropdown' => [
                    'items' => [
                        ['label' => 'Imágenes', 'url' => ['categorias/filtroimg', 'id' =>$categoria->id]],
                        ['label' => 'PDF', 'url' => ['categorias/filtropdf', 'id' =>$categoria->id]],
                        ['label' => 'Completos', 'url' => ['categorias/filtrocomp', 'id' =>$categoria->id]],
                        ['label' => 'Volver', 'url' => ['categorias/index']],
                    ],
                ],
                'options' => [
                    'class' => 'btn btn-warning btn-sm float-right',
                ]
        ]);?>
        
    </h3>

<section class="ftco-section bg-light" style="margin-top: 10px;">
  <div class="container">  
    <?= ListView::widget([
        'summary' => false,
        'itemOptions' => ['tag' => null],
        'dataProvider' => $dataProvider,
        'itemView' => '_recursos',
        'options' => [
          'class' => 'row',
      ],
    ]); ?>
  </div>
</section>