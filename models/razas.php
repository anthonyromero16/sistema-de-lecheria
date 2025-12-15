<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "razas".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $fecha_creado
 * @property string|null $fecha_actualizado
 *
 * @property Animales[] $animales
 */
class razas extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'razas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'default', 'value' => null],
            [['nombre'], 'required'],
            [['descripcion'], 'string'],
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
            'descripcion' => 'Descripcion',
            'fecha_creado' => 'Fecha Creado',
            'fecha_actualizado' => 'Fecha Actualizado',
        ];
    }

    /**
     * Gets query for [[Animales]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnimales()
    {
        return $this->hasMany(Animales::class, ['id_raza' => 'id']);
    }

}
