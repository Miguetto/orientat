<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use dmstr\cookieconsent\widgets\CookieConsent;


AppAsset::register($this);
$usuario_id = Yii::$app->user->id;
$url = Url::to(['usuarios/view', 'id' => $usuario_id]);

$urlCookie = Url::toRoute(['site/cookie', 'cadena' => 'politica'], $schema = true);

$jsCook = <<<EOT
    $(#modalCook).show();    
EOT;
if (!isset($_COOKIE['politica'])) {

    $this->registerJs($jsCook);
};

?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="manifest" href="./manifest.json">
    <link rel="manifest" href="/app.webmanifest" crossorigin="use-credentials">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#F0DB4F">
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'orientaT',//Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-dark bg-dark ftco_navbar ftco-navbar-light fixed-top',
        ],
        'collapseOptions' => [
            'class' => 'justify-content-end',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            Yii::$app->user->isGuest ? 
            ['label' => 'Registrarse', 'url' => ['/usuarios/create']]
            :
            ['label' => 'Inicio', 'url' => ['/site/index']],
            //['label' => 'Contacto', 'url' => ['/site/contact']],
            !Yii::$app->user->isGuest ? 
            (Yii::$app->user->identity->esAdmin === true ? 
            (['label' => 'Administración', 'url' => ['/usuarios/herramientas']]) : ('')) : (''),
            ['label' => 'Propuestas', 'url' => ['/propuestas/index'], 'visible' => !Yii::$app->user->isGuest],
            ['label' => 'Recursos', 'url' => ['/recursos/index'], 'visible' => !Yii::$app->user->isGuest],
            ['label' => 'Categorías', 'url' => ['/categorias/index'], 'visible' => !Yii::$app->user->isGuest],
            ['label' => 'Notificaciones', 'url' => ['/notificaciones/index'], 'visible' => !Yii::$app->user->isGuest],
            ['label' => 'Mi perfil', 'url' => $url, 'visible' => !Yii::$app->user->isGuest],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li class="nav-item deslog">'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-outline-info nav-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<!-- Pie de página -->
<footer class="ftco-footer ftco-bg-dark ftco-section">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-12 text-center">
                <p>
                    &copy; orientaT <?= date('Y') ?> Todos los derechos reservados |  Creado por <?= Html::a('Miguetto', Url::to('https://github.com/Miguetto')) ?> | <?= Yii::powered() ?>
                </p>
          </div>
        </div>
      </div>
</footer>
<?= CookieConsent::widget([
    'name' => 'cookie_consent_status',
    'path' => '/',
    'domain' => '',
    'expiryDays' => 365,
    'message' => 
        'Utilizamos cookies propias para mejorar la experiencia del usuario a través de su navegación.
         Si continúas navegando aceptas su uso. <a href="https://www.modelosycontratos.com/politica-de-cookies/" target="blacnk">Política de cookies</a> ',
    'acceptAll' => 'Aceptar',
    'controlsOpen' => false,
    'detailsOpen' => false,
    'learnMore' =>  false,
    'consent' => [
        'necesario' => [
            'label' => 'Necesario',
            'checked' => true,
            'disabled' => true
        ],
    ],
]) ?>

<?php 
    $this->endBody();
?>
</body>
</html>
<?php $this->endPage() ?>
