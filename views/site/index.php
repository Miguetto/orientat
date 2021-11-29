<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;
use dmstr\cookieconsent\widgets\CookieConsent;

$this->title = 'orientaT';
?>
<div class="site-index">
<section class="home-slider owl-carousel owl-loaded owl-drag">
  <div class="slider-item" style="background-image:url(images/bg_2.jpg);">
  <div class="overlay"></div>
      <div class="container-wrap">
        <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-8 text-center ftco-animate">
            <h1 id="titulo">Recursos educativos accesibles, facilitadores y gratuitos.</h1>
            <p>
              <?= Html::a('Registrarse', ['usuarios/create'], ['class' => 'btn btn-secondary px-4 py-3 mt-3']) ?>
            </p>
          </div>
        </div>
      </div>
  </div>
</section>
    <section id="dAzul" class="ftco-services ftco-no-pb">
			<div class="container-wrap">
				<div class="row no-gutters">
                    <div class="col-md-3 d-flex services align-self-stretch pb-4 px-4 bg-primary">
                        <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                                <span class="flaticon-teacher"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Por y para vosotrxs</h3>
                            <p>Añade, utiliza, comparte, dale el uso que quieras.</p>
                        </div>
                        </div>      
                    </div>
                    <div class="col-md-3 d-flex services align-self-stretch pb-4 px-4 bg-tertiary">
                        <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                                <span class="flaticon-reading"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Aprendizaje</h3>
                            <p>Divididos según el grado de aprendizaje, desde infantil hasta formación profesional.</p>
                        </div>
                        </div>    
                    </div>
                    <div class="col-md-3 d-flex services align-self-stretch pb-4 px-4 bg-fifth">
                        <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                                <span class="flaticon-books"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Recursos</h3>
                            <p>Ofrecemos recursos en pdf, formato blog, imágenes, enlaces. También puedes proponer nuevos recursos.</p>
                        </div>
                        </div>      
                    </div>
                    <div class="col-md-3 d-flex services align-self-stretch pb-4 px-4 bg-quarternary">
                        <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                                <span class="flaticon-diploma"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Revisión</h3>
                            <p>Todos los recursos compartidos están revisados por el equipo de revisores antes de ser puestos a tú disposición</p>
                        </div>
                        </div>      
                    </div>
                </div>
			</div>
	</section>
</div>