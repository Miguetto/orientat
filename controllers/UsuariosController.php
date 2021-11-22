<?php

namespace app\controllers;

use app\models\Recursos;
use app\models\RecursosSearch;
use app\models\Roles;
use Yii;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use yii\bootstrap4\Html;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
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
                'only' => ['index', 'create', 'update', 'delete', 'view', 'herramientas'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'herramientas'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->esAdmin;
                        },
                    ],
                    [
                        'actions' => ['update', 'delete', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuarios model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $usuario = $this->findModel($id);
        $recursos = Recursos::find()->where(['usuario_id' => Yii::$app->user->id])->all();

        return $this->render('view', [
            'usuario' => $usuario,
            'recursos' => $recursos,
        ]);
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuarios(['scenario' => Usuarios::SCENARIO_CREATE]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(Yii::$app->user->isGuest){

                Yii::$app->session->setFlash(
                    'info',
                    'Confirma para activar el usuario, mira en tu correo: ' . $model->email
                );

                $body = 'Para activar el usuario, pulse aquí: '
                        . Html::a('Activar usuario',
                            Url::to([
                                'usuarios/validar',
                                'id' => $model->id,
                                'token_confirm' => $model->token_confirm
                            ], true)
                        );

                // envío del email:        
                Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['smtpUsername'])
                ->setTo($model->email)
                ->setSubject('Activar usuario ')
                ->setHtmlBody($body)
                ->send();

                Yii::$app->session->setFlash('success', 'Debe activar al usuario para validar la cuenta.');
                
                return $this->redirect(['site/login']);
            }else if(Yii::$app->user->identity->esAdmin){
                Yii::$app->session->setFlash('success', 'Se creó correctamente.');
                return $this->redirect(['view', 'id' => $model->id]);
            }            
        }

        return $this->render('create', [
            'model' => $model,
            'roles' => Roles::lista(),
        ]);
    }

    /**
     * Acción que valida una cuenta de correo
     * Comprueba si se validó
     * @param  [type] $token_confirm es una cadena aleatoriaa que pertenece
     *                               al usuario que se registra.
     * @return redirect              Redirección al formulario de inicio
     *                               de sesión.
     */
    public function actionValidar($id,$token_confirm)
    {
        $model = $this->findModel($id);
        if ($model->token_confirm === $token_confirm) {
            $model->token_confirm = null;
            $model->save();    
            Yii::$app->session->setFlash('success',  'Usuario activado correctamente, logueate!!.');
            return $this->redirect(['site/login']);
        } else {
            Yii::$app->session->setFlash('danger',  'Usuario activado anteriormente.');
            return $this->redirect(['site/index']);    
        }
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Usuarios::SCENARIO_UPDATE;
        $model->password = '';

        if(Yii::$app->user->identity->esAdmin || $model->id == Yii::$app->user->id){
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
                'roles' => Roles::lista(),

            ]);
        }else{
            Yii::$app->session->setFlash('error', 'No se pudo hacer eso.');
            return $this->redirect(['site/index']);
        }    
        
    }

    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->identity->esAdmin || $model->id == Yii::$app->user->id) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Se eliminó correctamente.');
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error', 'No se pudo hacer eso.');
            return $this->redirect(['site/index']);
        }

    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Para darse de baja de la web.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionBaja($id)
    {
        $model = new Usuarios(['scenario' => Usuarios::SCENARIO_BAJA]);
        $model = $this->findModel($id);

        if($model->de_baja == false){
            Yii::$app->session->setFlash(
                'info',
                'Confirma para dar de baja el usuario, mira en tu correo: ' . $model->email
            );

            $model->token_confirm = Yii::$app->security->generateRandomString();

            $body = 'Para dar de baja el usuario, pulse aquí: '
                    . Html::a('Darse de baja',
                        Url::to([
                            'usuarios/cbaja',
                            'id' => $model->id,
                            'token_confirm' => $model->token_confirm
                        ], true)
                    );

            // envío del email:        
            Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['smtpUsername'])
            ->setTo($model->email)
            ->setSubject('Dar de baja el usuario ')
            ->setHtmlBody($body)
            ->send();            
            
            $model->save();
            return $this->redirect(['site/index']);
        }else{
            Yii::$app->session->setFlash('error', 'No se pudo hacer eso.');
            return $this->redirect(['site/index']);
        }   
    }

    /**
     * Acción para confirmar la baja de usuario
     * Comprueba si se confirmó
     * @param  [type] $token_confirm es una cadena aleatoriaa que pertenece
     *                               al usuario que se registra.
     * @return redirect              Redirección al formulario de inicio
     *                               de sesión.
     */
    public function actionCbaja($id,$token_confirm)
    {
        $model = $this->findModel($id);
        if ($model->token_confirm === $token_confirm) {
            $model->token_confirm = null;
            $model->de_baja = true;
            $model->save();    
            Yii::$app->session->setFlash('success',  'Usuario dado de baja de la web correctamente, hasta la próxima.');
            return $this->redirect(['site/login']);
        } else {
            Yii::$app->session->setFlash('danger',  'El usuario sigue dado de alta en la web.');
            return $this->redirect(['site/index']);    
        }
    }

    /**
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionHerramientas()
    {
        $searchModel = new UsuariosSearch();
        $searchModel2 = new RecursosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);

        $recursos = Recursos::find();

        $usuarios = Usuarios::find();
        
        return $this->render('herramientas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'recursos' => $recursos->all(),
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
        ]);        
    }
}
