<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Propuestas */

$this->title = 'Create Propuestas';
$this->params['breadcrumbs'][] = ['label' => 'Propuestas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="propuestas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'usuarios' => $usuarios,
    ]) ?>

</div>
