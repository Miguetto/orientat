<?php

namespace app\controllers;

use app\models\Categorias;
use Yii;
use app\models\Recursos;
use app\models\RecursosSearch;
use app\models\Usuarios;
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
        $recursos = Recursos::find()->all();
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
        
        return $this->render('view', [
            'model' => $this->findModel($id),
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
            $model->upload();
            $model->save();
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
}
