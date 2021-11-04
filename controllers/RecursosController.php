<?php

namespace app\controllers;

use app\components\Utilidad;
use app\models\Categorias;
use app\models\Comentarios;
use Yii;
use app\models\Recursos;
use app\models\RecursosSearch;
use app\models\Usuarios;
use DateTime;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * RecursosController implements the CRUD actions for Recursos model.
 */
class RecursosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->esAdmin || Yii::$app->user->identity->esRevisor;
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Recursos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = Recursos::find()->one();
        $recursos = Recursos::find()->where('revisado=true')->all();
        $searchModel = new RecursosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'recursos' => $recursos,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Recursos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $usuarioLogueado = Yii::$app->user->identity['username'];
        $comentarios = Comentarios::find()->where(['recurso_id' => $id])->all();
        $recurso = Recursos::find()->where(['id' => $id])->all();

        $comentarioYnomUsuario = [];
        $fechasComentarios = [];
        $comentarioIdYnomb = [];
        $idComentarioN = 0;

        if($comentarios == null){
            $idComentarioN = 1;
        }

        foreach($recurso as $usuario){
            $usuarioRecurso = Usuarios::find()->where(['id' => $usuario->usuario_id])->one()['username']; 
        }

        foreach($comentarios as $comentario){  
            $nombreUsuario = Usuarios::find()->where(['id' => $comentario->usuario_id])->one()['username'];
            $cuerpoComentario = $comentario->cuerpo;
            $idComentario = $comentario->id;
            $fecha = $comentario->created_at;
            $fecha = new DateTime($fecha);
            $fecha = $fecha->format('d-m-Y H:i:s');
            $fecha = Utilidad::formatoFecha($fecha);

            $comentarioYnomUsuario += [
                $nombreUsuario => $cuerpoComentario,
            ];
            $fechasComentarios += [
                $nombreUsuario => $fecha,
            ];
            $comentarioIdYnomb += [
                $idComentario => $nombreUsuario,
            ];
        }
        if(isset($idComentario)){
            $idComentarioN = $idComentario+1;    
        }
        //var_dump($usuarioRecurso);die();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'comentarioYnomUsuario' => $comentarioYnomUsuario,
            'fechasComentarios' => $fechasComentarios,
            'usuarioLogueado' => $usuarioLogueado,
            'comentarioIdYnomb' => $comentarioIdYnomb,
            'idComentarioN' => $idComentarioN,
            'usuarioRecurso' => $usuarioRecurso,
        ]);
    }

    /**
     * Creates a new Recursos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Recursos();

        if ($model->load(Yii::$app->request->post())) {
            $model->img = UploadedFile::getInstance($model, 'img');
            $model->pdf = UploadedFile::getInstance($model, 'pdf');
            $model->upload();
            $model->uploadPdf();
            $model->save();
            Yii::$app->session->setFlash(
                'info',
                'Recurso creado y en espera de ser revisado para publicarlo.'
            );
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'usuarios' => Usuarios::lista(),
            'categorias' => Categorias::lista(),
        ]);
    }

    /**
     * Updates an existing Recursos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash(
                'info',
                'Recurso modificado correctamente.'
            );
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'usuarios' => Usuarios::lista(),
            'categorias' => Categorias::lista(),
        ]);
    }

    /**
     * Deletes an existing Recursos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash(
            'success',
            'Recurso eliminado correctamente.'
        );
        return $this->redirect(['index']);
    }

    /**
     * Finds the Recursos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Recursos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Recursos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Acción que actualiza el dato de la fila revisado.
     */
    public function actionRevisado($id)
    {
        $model = $this->findModel($id);

        $model->revisado = 'true';
        $model->save();
        Yii::$app->session->setFlash(
            'info',
            'Recurso revisado y aceptado correctamente.'
        );
        return $this->redirect(['recursos/index']);
    }

    public function actionPdf($id) {
        $model = Recursos::findOne($id);
        $ruta = 'https://orecursos.s3.eu-west-3.amazonaws.com/pdf/'. $model->pdf_pdf;
        return Yii::$app->response->sendFile($ruta);
    }
}