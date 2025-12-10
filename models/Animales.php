<?php
namespace app\models;
use Yii;

/**
 * This is the model class for table "animales".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property resource|null $imagen
 * @property int|null $id_raza
 * @property string|null $fecha_nacimiento
 * @property float|null $peso_kg
 * @property float|null $temperatura_celsius
 * @property int|null $id_usuario
 * @property string|null $fecha_creado
 * @property string|null $fecha_actualizado
 *
 * @property AnimalVacuna[] $animalVacunas
 * @property Produccion[] $produccions
 * @property Razas $raza
 * @property Usuarios $usuario
 * @property Veterinaria[] $veterinarias
 */
class Animales extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'animales';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'imagen', 'id_raza', 'fecha_nacimiento', 'peso_kg', 'temperatura_celsius', 'id_usuario'], 'default', 'value' => null],
            [['nombre'], 'required'],
            [['descripcion'], 'string'],
            [['imagen'], 'safe'],
            [['id_raza', 'id_usuario'], 'integer'],
            [['fecha_nacimiento', 'fecha_creado', 'fecha_actualizado'], 'safe'],
            [['peso_kg', 'temperatura_celsius'], 'number'],
            [['nombre'], 'string', 'max' => 100],
            [['id_raza'], 'exist', 'skipOnError' => true, 'targetClass' => Razas::class, 'targetAttribute' => ['id_raza' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'imagen' => 'Imagen',
            'id_raza' => 'Id Raza',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'peso_kg' => 'Peso Kg',
            'temperatura_celsius' => 'Temperatura Celsius',
            'id_usuario' => 'Id Usuario',
            'fecha_creado' => 'Fecha Creado',
            'fecha_actualizado' => 'Fecha Actualizado',
        ];
    }

    /**
     * Gets query for [[AnimalVacunas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnimalVacunas()
    {
        return $this->hasMany(AnimalVacuna::class, ['id_animal' => 'id']);
    }

    /**
     * Gets query for [[Produccions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduccions()
    {
        return $this->hasMany(Produccion::class, ['id_animal' => 'id']);
    }

    /**
     * Gets query for [[Raza]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRaza()
    {
        return $this->hasOne(Razas::class, ['id' => 'id_raza']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'id_usuario']);
    }

    /**
     * Gets query for [[Veterinarias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVeterinarias()
    {
        return $this->hasMany(Veterinaria::class, ['id_animal' => 'id']);
    }

public function fields()
{
    $fields = parent::fields();

    $fields['imagen'] = function ($model) {
        if (!empty($model->imagen)) {
            // Ya est¨¢ codificada como Base64 por afterFind()
            return 'data:image/jpeg;base64,' . $model->imagen;
        }
        return null;
    };

    return $fields;
}


public function afterFind()
{
    parent::afterFind();
    if (!empty($this->imagen)) {
        $this->imagen = base64_encode($this->imagen);
    }
}
}