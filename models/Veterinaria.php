<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "veterinaria".
 *
 * @property int $id
 * @property int $id_animal
 * @property string $tipo_evento
 * @property string $fecha
 * @property string|null $descripcion
 * @property string|null $fecha_creado
 * @property string|null $fecha_actualizado
 *
 * @property Animales $animal
 */
class Veterinaria extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'veterinaria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'default', 'value' => null],
            [['id_animal', 'tipo_evento', 'fecha'], 'required'],
            [['id_animal'], 'integer'],
            [['fecha', 'fecha_creado', 'fecha_actualizado'], 'safe'],
            [['descripcion'], 'string'],
            [['tipo_evento'], 'string', 'max' => 100],
            [['id_animal'], 'exist', 'skipOnError' => true, 'targetClass' => Animales::class, 'targetAttribute' => ['id_animal' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_animal' => 'Id Animal',
            'tipo_evento' => 'Tipo Evento',
            'fecha' => 'Fecha',
            'descripcion' => 'Descripcion',
            'fecha_creado' => 'Fecha Creado',
            'fecha_actualizado' => 'Fecha Actualizado',
        ];
    }

    /**
     * Gets query for [[Animal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnimal()
    {
        return $this->hasOne(Animales::class, ['id' => 'id_animal']);
    }

}
