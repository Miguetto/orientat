<?php

namespace app\controllers;

use Yii;
use app\models\Comentarios;
use app\models\ComentariosSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComentariosController implements the CRUD actions for Comentarios model.
 */
class ComentariosController extends Controller
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
                'only' => ['view', 'index'],
                'rules' => [
                    [
                        'actions' => ['create','update', 'delete', 'view', 'index'],
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
     * Lists all Comentarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComentariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comentarios model.
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
     * Creates a new Comentarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($recurso_id)
    {
        $usuario_id = Yii::$app->user->id;

        $model = new Comentarios();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['recursos/view', 'id' => $recurso_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'usuario_id' => $usuario_id,
            'recurso_id' => $recurso_id,
        ]);
    }

    /**
     * Updates an existing Comentarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $recurso_id)
    {
        $model = $this->findModel($id);
        $usuario_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['recursos/view', 'id' => $recurso_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'recurso_id' => $recurso_id,
            'usuario_id' => $usuario_id,
        ]);
    }

    /**
     * Deletes an existing Comentarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $recurso_id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['recursos/view', 'id' => $recurso_id]);
    }

    /**
     * Finds the Comentarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comentarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comentarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
