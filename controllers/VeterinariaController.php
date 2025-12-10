<?php

namespace app\controllers;

use app\models\Veterinaria;
use app\models\VeterinariaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VeterinariaController implements the CRUD actions for Veterinaria model.
 */
class VeterinariaController extends Controller
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
     * Lists all Veterinaria models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new VeterinariaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Veterinaria model.
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
     * Creates a new Veterinaria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Veterinaria();

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
     * Updates an existing Veterinaria model.
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
     * Deletes an existing Veterinaria model.
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
     * Finds the Veterinaria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Veterinaria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
// ... tus m¨¦todos index, view, create, update, delete ...

public function actionGetEvents()
{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $events = (new \yii\db\Query())
        ->select(['id', 'id_animal', 'tipo_evento', 'fecha', 'descripcion'])
        ->from('veterinaria')
        ->orderBy('fecha ASC')
        ->all();

    return $events;
}

public function actionGetCows()
{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $cows = (new \yii\db\Query())
        ->select(['id', 'nombre', 'descripcion'])
        ->from('animales')
        ->all();

    return $cows;
}

protected function findModel($id)
{
    if (($model = Veterinaria::findOne(['id' => $id])) !== null) {
        return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
}

public function actionCowDetails($id)
{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    // Informaci¨®n b¨¢sica del animal
    $animal = (new \yii\db\Query())
        ->select(['a.id', 'a.nombre', 'a.descripcion', 'r.nombre AS raza'])
        ->from('animales a')
        ->leftJoin('razas r', 'a.id_raza = r.id')
        ->where(['a.id' => $id])
        ->one();

    // Eventos veterinarios
    $eventos = (new \yii\db\Query())
        ->select(['tipo_evento', 'fecha', 'descripcion'])
        ->from('veterinaria')
        ->where(['id_animal' => $id])
        ->orderBy(['fecha' => SORT_DESC])
        ->all();

    // Vacunas aplicadas
    $vacunas = (new \yii\db\Query())
        ->select(['v.nombre AS vacuna', 'av.fecha_aplicacion', 'av.observaciones'])
        ->from('animal_vacuna av')
        ->leftJoin('vacunas v', 'v.id = av.id_vacuna')
        ->where(['av.id_animal' => $id])
        ->orderBy(['av.fecha_aplicacion' => SORT_DESC])
        ->all();

    return [
        'animal' => $animal,
        'eventos' => $eventos,
        'vacunas' => $vacunas
    ];
}


}
