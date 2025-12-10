<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vacunas".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $fecha_creado
 * @property string|null $fecha_actualizado
 *
 * @property AnimalVacuna[] $animalVacunas
 */
class Vacunas extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacunas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['fecha_creado', 'fecha_actualizado'], 'safe'],
            [['nombre'], 'string', 'max' => 100],
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
        return $this->hasMany(AnimalVacuna::class, ['id_vacuna' => 'id']);
    }

}
