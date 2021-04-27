<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Propuestas */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Propuestas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="propuestas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(Yii::$app->user->identity->esAdmin || Yii::$app->user->identity->esRevisor){ ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php } ?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'titulo',
            'descripcion',
            'created_at',
            'usuario.username',
        ],
    ]) ?>

</div>
