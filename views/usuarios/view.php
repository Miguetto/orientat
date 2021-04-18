<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Perfil de '. $usuario->username;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $usuario->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $usuario->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Vas a eliminarlo?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $usuario,
        'attributes' => [
            'nombre',
            'username',
            'email:email',
            'rol.rol',
        ],
    ]) ?>

    <h3>Mis recursos:</h3>

    <?= GridView::widget([
        'dataProvider' => $dataProviderRecursosUsuario,
        'columns' => [
            'titulo',
            'descripcion',
            'contenido',
            'created_at:date',
            'categoria.nombre:text:Categoría',
            
            [
                '__class' => ActionColumn::class,
                'template' => '{ver}',
                'buttons' => [
                    'ver' => function ($url, $model) {
                        return Html::a(
                            'Ver',
                            [
                                'recursos/view',
                                'id' => $model->id,
                            ],
                            [
                                'class' => 'btn-sm btn-primary',
                                'data-method' => 'POST',
                            ],
                        );
                    }
                ]
            ],
        ],
    ]) ?>

</div>
