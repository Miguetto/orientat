<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecursosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recursos:';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="recursos-index services-2 btnSuperior">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Crear Recurso', ['create'], ['class' => 'btn btn-success', 'id' => 'e']) ?>
  </p>

</div>
<?= $this->render('_search', ['model' => $searchModel]); ?>


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
