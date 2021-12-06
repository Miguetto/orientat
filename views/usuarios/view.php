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
        <?= Html::a('Darse de baja', ['baja', 'id' => $usuario->id], [
            'class' => 'btn btn-secondary',
            'data' => [
                'confirm' => '¿Vas a darte de baja?',
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
            'de_baja:boolean',
        ],
    ]) ?>

    <h3>Mis recursos:</h3>
    
    <?php /*GridView::widget([
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
    ]) */?>

<div class="container">
				<div class="row">
                <?php foreach ($recursos as $recurso) : ?>
          <div class="col-md-6 col-lg-4">
            <div class="blog-entry">
              <a class="block-20 d-flex align-items-end" style="background-image: url('<?= $recurso->getImagen(); ?>');">
								<div class="meta-date text-center p-2">
                  <span class="day"><?= Yii::$app->formatter->asDate($recurso->created_at, 'long') ?></span>
                </div>
              </a>
              <div class="text bg-white p-4">
                <h3 class="heading"><?= Html::a($recurso->titulo, ['recursos/view', 'id' => $recurso->id]) ?></h3>
                <p><?= $recurso->descripcion; ?></p>
                <div class="d-flex align-items-center mt-4">
	                <p class="mb-0">
                        <?= Html::a('Seguir leyendo', ['recursos/view', 'id' => $recurso->id], ['class' => 'btn btn-secondary']) ?>
                    </p>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach ?>
    </div>
</div>

</div>
