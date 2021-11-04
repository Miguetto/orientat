<?php

namespace app\controllers;

use Yii;
use app\models\Likes;
use app\models\LikesSearch;
use app\models\Usuarios;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LikesController implements the CRUD actions for Likes model.
 */
class LikesController extends Controller
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
     * Lists all Likes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LikesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Likes model.
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
     * Creates a new Likes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Likes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Likes model.
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
        ]);
    }

    /**
     * Deletes an existing Likes model.
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
     * Finds the Likes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Likes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Likes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Guardar un Like
     *
     * @param integer $usuario_id
     * @param integer $recurso_id
     * @return mixed
     */
    public function actionLikes($recurso_id)
    {
        $model = new Likes();
        $existe = $model->find()->where(['usuario_id' => Yii::$app->user->identity->id, 'recurso_id' => $recurso_id])->exists();

        $model->usuario_id = Yii::$app->user->identity->id;
        $model->recurso_id = $recurso_id;
        if ($existe){
            $model->find()->where(['usuario_id' => Yii::$app->user->identity->id, 'recurso_id' => $recurso_id])->one()->delete();
            return $this->redirect(['recursos/index']);
        }else if($model->save()) {
                
            return $this->redirect(['recursos/index']);

        }
        /*if (Yii::$app->request->isAjax && Yii::$app->request->isGet) {
            if ($existe) {
                $j = $model->find()->where(['recurso_id' => $recurso_id])->count();
                return json_encode(['class' => 'fas', 'contador' => $j]);
            } else {
                $j = $model->find()->where(['recurso_id' => $recurso_id])->count();
                return json_encode(['class' => 'far', 'contador' => $j]);
            }
        }

        if ($existe && $model->find()->where(['usuario_id' => Yii::$app->user->identity->id, 'recurso_id' => $recurso_id])->one()->delete()) {
            if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
                $j = $model->find()->where(['recurso_id' => $recurso_id])->count();
                return json_encode(['class' => 'far', 'contador' => $j]);
            }
        } else {
            $model->usuario_id = Yii::$app->user->identity->id;
            $model->recurso_id = $recurso_id;
            if ($model->save()) {
                $j = $model->find()->where(['recurso_id' => $recurso_id])->count();
                return json_encode(['class' => 'fas', 'contador' => $j]);
            }
        }*/
    }
}
