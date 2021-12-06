<?php

namespace app\controllers;

use Yii;
use app\models\Categorias;
use app\models\CategoriasSearch;
use app\models\RecursosSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriasController implements the CRUD actions for Categorias model.
 */
class CategoriasController extends Controller
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
                ],
            ],
        ];
    }

    /**
     * Lists all Categorias models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoriasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categorias model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $categoria = $this->findModel($id);
        $searchModel = new RecursosSearch();
        $dataProvider = $searchModel->searchRecursosCategoria(Yii::$app->request->queryParams, $id);

        return $this->render('view', [
            'categoria' => $categoria,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Categorias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Categorias();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Categorias model.
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
     * Deletes an existing Categorias model.
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
     * Finds the Categorias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categorias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categorias::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Recursos con imagenes.
     * @return mixed
     */
    public function actionFiltroimg($id)
    {
        $categoria = $this->findModel($id);
        $searchModel = new RecursosSearch();
        $dataProvider = $searchModel->searchRecursosImg(Yii::$app->request->queryParams, $id);

        return $this->render('_img', [
            'categoria' => $categoria,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);   
    }

    /**
     * Recursos con pdf.
     * @return mixed
     */
    public function actionFiltropdf($id)
    {
        $categoria = $this->findModel($id);
        $searchModel = new RecursosSearch();
        $dataProvider = $searchModel->searchRecursosPdf(Yii::$app->request->queryParams, $id);

        return $this->render('_pdf', [
            'categoria' => $categoria,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);    
    }

    /**
     * Recursos con pdf.
     * @return mixed
     */
    public function actionFiltrocomp($id)
    {
        $categoria = $this->findModel($id);
        $searchModel = new RecursosSearch();
        $dataProvider = $searchModel->searchRecursosComp(Yii::$app->request->queryParams, $id);

        return $this->render('_com', [
            'categoria' => $categoria,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);     
    }
}
