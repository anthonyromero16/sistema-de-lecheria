<?php

namespace app\controllers;

use app\models\Animales;
use app\models\AnimalesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AnimalesController implements the CRUD actions for Animales model.
 */
class AnimalesController extends Controller
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
     * Lists all Animales models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AnimalesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Animales model.
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
     * Creates a new Animales model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Animales();

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
     * Updates an existing Animales model.
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
     * Deletes an existing Animales model.
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
     * Finds the Animales model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Animales the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Animales::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionApiList()
{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    // Trae todos los animales junto con el nombre de la raza
    $models = (new \yii\db\Query())
        ->from('animales')
        ->leftJoin('razas', 'razas.id = animales.id_raza')
        ->select([
            'animales.id',
            'animales.nombre',
            'animales.descripcion',
            'animales.id_raza',
            'razas.nombre AS nombre_raza',
            'animales.imagen'
        ])
        ->all();

    foreach ($models as &$animal) {
        // Imagen base64
        if (!empty($animal['imagen'])) {
            $animal['imagen_base64'] = 'data:image/jpeg;base64,' . base64_encode($animal['imagen']);
        } else {
            $animal['imagen_base64'] = ''; // JS puede mostrar la foto por defecto
        }
        unset($animal['imagen']);
    }

    return [
        "status" => "success",
        "data" => $models
    ];
}



public function actionApiView($id)
{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    // =====================
    // 1. Obtener animal + raza
    // =====================
    $animal = (new \yii\db\Query())
        ->from('animales')
        ->leftJoin('razas', 'razas.id = animales.id_raza')
        ->where(['animales.id' => $id])
        ->select([
            'animales.id',
            'animales.nombre',
            'animales.descripcion',
            'animales.fecha_nacimiento',
            'animales.peso_kg',
            'animales.temperatura_celsius',
            'animales.imagen',
            'razas.nombre AS raza'
        ])
        ->one();

    if (!$animal) {
        return [
            "status" => "error",
            "message" => "Animal no encontrado"
        ];
    }

    // =====================
    // 2. Convertir imagen BLOB ¡ú Base64
    // =====================
    if (!empty($animal['imagen'])) {
        $animal['foto'] = 'data:image/jpeg;base64,' . base64_encode($animal['imagen']);
    } else {
        $animal['foto'] = '';
    }
    unset($animal['imagen']);

    // =====================
    // 3. Ultima produccion (litros)
    // =====================
    $produccion = (new \yii\db\Query())
        ->from('produccion')
        ->where(['id_animal' => $id])
        ->select(['litros', 'fecha_extraido'])
        ->orderBy(['fecha_extraido' => SORT_DESC])
        ->one();

    if ($produccion) {
        $animal['produccion_ultima'] = $produccion['litros'];
        $animal['produccion_fecha'] = $produccion['fecha_extraido'];
    } else {
        $animal['produccion_ultima'] = null;
        $animal['produccion_fecha'] = null;
    }

    // =====================
    // 4. Ultimo evento de salud (veterinaria)
    // =====================
    $salud = (new \yii\db\Query())
        ->from('veterinaria')
        ->where(['id_animal' => $id])
        ->select(['tipo_evento', 'fecha', 'descripcion'])
        ->orderBy(['fecha' => SORT_DESC])
        ->one();

    if ($salud) {
        $animal['salud_evento'] = $salud['tipo_evento'];
        $animal['salud_fecha'] = $salud['fecha'];
        $animal['salud_descripcion'] = $salud['descripcion'];
    } else {
        $animal['salud_evento'] = null;
        $animal['salud_fecha'] = null;
        $animal['salud_descripcion'] = null;
    }

    return [
        "status" => "success",
        "data" => $animal
    ];
}
}