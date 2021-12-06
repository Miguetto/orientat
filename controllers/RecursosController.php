<?php

namespace app\controllers;

use app\components\Utilidad;
use app\models\Categorias;
use app\models\Comentarios;
use app\models\Likes;
use app\models\Notificaciones;
use Yii;
use app\models\Recursos;
use app\models\RecursosSearch;
use app\models\Respuestas;
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
        $searchModel = new RecursosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        
        $comentarios = Comentarios::find()->where(['recurso_id' => $id])->orderBy(['created_at' => SORT_DESC])->all();
        $recurso = Recursos::find()->where(['id' => $id])->all();
        
        $idComentarioN = 0;

        if($comentarios == null){
            $idComentarioN = 1;
        }

        foreach($recurso as $usuario){
            $usuarioRecurso = Usuarios::find()->where(['id' => $usuario->usuario_id])->one()['username']; 
        }

        if(isset($idComentario)){
            $idComentarioN = $idComentario+1;    
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'idComentarioN' => $idComentarioN,
            'usuarioRecurso' => $usuarioRecurso,
            'comentarios' => $comentarios,
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
        $revisores = Usuarios::find()->where(['rol_id' => 2])->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->img = UploadedFile::getInstance($model, 'img');
            $model->pdf = UploadedFile::getInstance($model, 'pdf');
            $model->upload();
            $model->uploadPdf();
            $model->save();

            // Creamos notificación:
                foreach($revisores as $revisor){
                    $model_notificacion = new Notificaciones([
                        'usuario_id' => $revisor->id,
                        'recurso_id' => $model->id,
                        'cuerpo' => 'Se ha creado un nuevo recurso: '. $model->titulo . ', y te ha sido asignado para revisar.'
                    ]);
                    $model_notificacion->save();
                }

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

        if ($model->load(Yii::$app->request->post())) {
            $model->img = UploadedFile::getInstance($model, 'img');
            $model->pdf = UploadedFile::getInstance($model, 'pdf');
            $model->upload();
            $model->uploadPdf();
            $model->save();
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
     * Acción que actualiza el dato de la fila revisado, validando el recurso y manda email al creador del recurso.
     */
    public function actionRevisado($id)
    {
        $model = $this->findModel($id);
        $model->revisado = 'true';
        $model->save();

        $body = 'Enhorabuena ' . $model->usuario->username . ', el recurso '. $model->titulo . ' ha sido validado con éxito.';
        
        // envío del email:        
        Yii::$app->mailer->compose()
        ->setFrom(Yii::$app->params['smtpUsername'])
        ->setTo($model->usuario->email)
        ->setSubject('Recurso validado ')
        ->setHtmlBody($body)
        ->send();

        Yii::$app->session->setFlash(
            'info',
            'Recurso revisado y aceptado correctamente.'
        );
        return $this->redirect(['recursos/index']);
    }

    /**
     * Acción que manda email al creador del recurso informando de que se deniega el recurso.
     */
    public function actionDenegado($id)
    {
        $model = $this->findModel($id);

        $body = 'Lo sentimos ' . $model->usuario->username . ', el recurso '. $model->titulo . ' ha sido denegado.';
        
        // envío del email:        
        Yii::$app->mailer->compose()
        ->setFrom(Yii::$app->params['smtpUsername'])
        ->setTo($model->usuario->email)
        ->setSubject('Recurso denegado ')
        ->setHtmlBody($body)
        ->send();

        $model->delete();
        
        Yii::$app->session->setFlash(
            'info',
            'Recurso denegado correctamente.'
        );
        return $this->redirect(['recursos/index']);
    }

    /**
     * Función que nos devuelve el pdf del servidor.
     *
     * @param integer $id
     * @return fichero
     */
    public function actionPdf($id) {
        $model = Recursos::findOne($id);
        $ruta = 'https://orecursos.s3.eu-west-3.amazonaws.com/pdf/'. $model->pdf_pdf;
        return Yii::$app->response->sendFile($ruta);
    }

    /**
     * Función que genera un like por ajax.
     *
     * @return mixed 
     */
    public function actionLike(){
        if(Yii::$app->request->isAjax){
            $usuario_id = Yii::$app->user->id;
            $recurso_id = Yii::$app->request->post('id');

            $modelo_like = new Likes([
                'usuario_id' => $usuario_id,
                'recurso_id' => $recurso_id
            ]);
            $modelo_like->save();

            $modelo_recurso = $this->findModel($recurso_id);
            
            $modelo_recurso->likes += 1;
            $modelo_recurso->save();

            $num_likes = $modelo_recurso->likes; 

            return $this->asJson([
                'response' => $num_likes,
                'recurso_id' => $recurso_id,
            ]);

        }
    }

    /**
     * Función que genera un disLike por ajax.
     *
     * @return mixed 
     */
    public function actionDislike(){
        if(Yii::$app->request->isAjax){
            
            $recurso_id = Yii::$app->request->post('id');

            $modelo_like = Likes::find()->where(['recurso_id' => $recurso_id])->one();

            if ($modelo_like !== null) {
                $modelo_like->delete();
            }

            $modelo_recurso = $this->findModel($recurso_id);

            if ($modelo_recurso->likes !== 0) {
                $modelo_recurso->likes -= 1;
            }
            $modelo_recurso->save();

            $num_likes = $modelo_recurso->likes;

            return $this->asJson([
                'response' => $num_likes,
                'recurso_id' => $recurso_id,
            ]);

        }
    }

    /**
     * Lists all Recursos models.
     * @return mixed
     */
    public function actionSinRevisar()
    {
        $searchModel = new RecursosSearch();
        $dataProvider = $searchModel->searchSinRevisar(Yii::$app->request->queryParams);
        
        return $this->render('_sinRevisar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}