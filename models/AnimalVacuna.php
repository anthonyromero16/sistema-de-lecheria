<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "animal_vacuna".
 *
 * @property int $id
 * @property int $id_animal
 * @property int $id_vacuna
 * @property string|null $fecha_aplicacion
 * @property string|null $observaciones
 * @property string|null $fecha_creado
 * @property string|null $fecha_actualizado
 *
 * @property Animales $animal
 * @property Vacunas $vacuna
 */
class AnimalVacuna extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'animal_vacuna';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_aplicacion', 'observaciones'], 'default', 'value' => null],
            [['id_animal', 'id_vacuna'], 'required'],
            [['id_animal', 'id_vacuna'], 'integer'],
            [['fecha_aplicacion', 'fecha_creado', 'fecha_actualizado'], 'safe'],
            [['observaciones'], 'string'],
            [['id_animal'], 'exist', 'skipOnError' => true, 'targetClass' => Animales::class, 'targetAttribute' => ['id_animal' => 'id']],
            [['id_vacuna'], 'exist', 'skipOnError' => true, 'targetClass' => Vacunas::class, 'targetAttribute' => ['id_vacuna' => 'id']],
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
            'id_vacuna' => 'Id Vacuna',
            'fecha_aplicacion' => 'Fecha Aplicacion',
            'observaciones' => 'Observaciones',
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

    /**
     * Gets query for [[Vacuna]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVacuna()
    {
        return $this->hasOne(Vacunas::class, ['id' => 'id_vacuna']);
    }

}
