<?php

namespace app\controllers;

use Yii;
use app\models\Propuestas;
use app\models\PropuestasSearch;
use app\models\Usuarios;
use app\models\Votos;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PropuestasController implements the CRUD actions for Propuestas model.
 */
class PropuestasController extends Controller
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
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->esAdmin || Yii::$app->user->identity->esRevisor;
                        },
                    ],
                    [
                        'actions' => ['view', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Propuestas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $propuestas = Propuestas::find()->orderBy(['created_at' => SORT_DESC])->all();
        $searchModel = new PropuestasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'propuestas' => $propuestas,
        ]);
    }

    /**
     * Displays a single Propuestas model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Propuestas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Propuestas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'usuarios' => Usuarios::lista(),
        ]);
    }

    /**
     * Updates an existing Propuestas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'usuarios' => Usuarios::lista(),
        ]);
    }

    /**
     * Deletes an existing Propuestas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Propuestas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Propuestas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Propuestas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Función que generar un voto por ajax.
     *
     * @return mixed
     */
    public function actionVotos()
    {
        if(Yii::$app->request->isAjax){
            $propuesta_id = Yii::$app->request->post('id');
            $usuario_id = Yii::$app->user->id;

            $modelo_voto = new Votos([
                'usuario_id' => $usuario_id,
                'propuesta_id' => $propuesta_id
            ]);
            $modelo_voto->save();

            $modelo_propuesta = $this->findModel($propuesta_id);
            $modelo_propuesta->votos += 1;
            $modelo_propuesta->save();

            $num_votos = $modelo_propuesta->votos;
            $usuarioPropuesta = $modelo_propuesta->usuario_id;
            $titulo = $modelo_propuesta->titulo;
            $creadorPropuesta = Usuarios::find()->where(['id' => $usuarioPropuesta])->one();
            
            if($modelo_propuesta->votos == 20){
                $body = 'Enhorabuena ' . $creadorPropuesta->username . ', la propuesta '. $titulo . ' llegó a 20 votos.
                         Ya puedes crearla.';

                // envío del email:        
                Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['smtpUsername'])
                ->setTo($creadorPropuesta->email)
                ->setSubject('Crear la propuesta como recurso ')
                ->setHtmlBody($body)
                ->send();

                Yii::$app->session->setFlash('success', 'Bien, ha llegado a 20 votos!! Se acaba de avisar al revisor para que cree el recurso, gracias!!.');
            }
            
            return $this->asJson([
                'response' => $num_votos,
                'propuesta_id' => $propuesta_id,
            ]);
        }   
    }

    /**
     * Función para anular el voto por ajax.
     *
     * @return mixed 
     */
    public function actionAnular(){
        if(Yii::$app->request->isAjax){
            
            $propuesta_id = Yii::$app->request->post('id');

            $modelo_voto = Votos::find()->where(['propuesta_id' => $propuesta_id])->one();

            if ($modelo_voto !== null) {
                $modelo_voto->delete();
            }

            $modelo_propuesta = $this->findModel($propuesta_id);

            if ($modelo_propuesta->votos !== 0) {
                $modelo_propuesta->votos -= 1;
            }
            $modelo_propuesta->save();

            $num_votos = $modelo_propuesta->votos;

            return $this->asJson([
                'response' => $num_votos,
                'propuesta_id' => $propuesta_id,
            ]);

        }
    }
}
