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
        
    <h3>
        <?= $this->render('_recursosSearchImg', ['model' => $searchModel, 'id' => $categoria->id]); ?>
        Recursos con imágenes:
                
        <?= ButtonDropdown::widget([
                'label' => 'Filtrar recursos por: ',
                'dropdown' => [
                    'items' => [
                        ['label' => 'PDF', 'url' => ['categorias/filtropdf', 'id' =>$categoria->id]],
                        ['label' => 'Completos', 'url' => ['categorias/filtrocomp', 'id' =>$categoria->id]],
                        ['label' => 'Todos', 'url' => ['categorias/view', 'id' =>$categoria->id]],
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
