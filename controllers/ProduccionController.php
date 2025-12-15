<?php

namespace app\controllers;

use app\models\Produccion;
use app\models\ProduccionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii;

/**
 * ProduccionController implements the CRUD actions for Produccion model.
 */
class ProduccionController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Produccion models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProduccionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Produccion model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Produccion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Produccion();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Produccion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Produccion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Produccion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Produccion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Produccion::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDashboardProduccion()
    {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $conn = Yii::$app->db;

    // Producci¨®n por d¨ªa
    $porDia = $conn->createCommand("
        SELECT fecha_extraido, SUM(litros) AS total_litros
        FROM produccion
        GROUP BY fecha_extraido
        ORDER BY fecha_extraido ASC
    ")->queryAll();

    // Producci¨®n por animal
    $porAnimal = $conn->createCommand("
        SELECT a.nombre AS animal, SUM(p.litros) AS total_litros
        FROM produccion p
        JOIN animales a ON p.id_animal = a.id
        GROUP BY p.id_animal
        ORDER BY total_litros DESC
    ")->queryAll();

    // (Opcional) Producci¨®n por tipo de leche
    $porTipo = $conn->createCommand("
        SELECT tipo_leche, SUM(litros) AS total_litros
        FROM produccion
        GROUP BY tipo_leche
    ")->queryAll();

    return [
        'status' => 'success',
        'produccion_dia' => $porDia,
        'produccion_animal' => $porAnimal,
        'produccion_tipo' => $porTipo
    ];
    }
}
