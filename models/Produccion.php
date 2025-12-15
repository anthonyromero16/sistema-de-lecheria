<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produccion".
 *
 * @property int $id
 * @property int $id_animal
 * @property string $fecha_extraido
 * @property float|null $litros
 * @property string|null $fecha_creado
 * @property string|null $fecha_actualizado
 *
 * @property Animales $animal
 */
class Produccion extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produccion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['litros'], 'default', 'value' => null],
            [['id_animal', 'fecha_extraido'], 'required'],
            [['id_animal'], 'integer'],
            [['fecha_extraido', 'fecha_creado', 'fecha_actualizado'], 'safe'],
            [['litros'], 'number'],
            [['tipo_leche'], 'in', 'range' => ['entera', 'descremada', 'calostro', 'crema', 'suero']],
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
            'fecha_extraido' => 'Fecha Extraido',
            'litros' => 'Litros',
            'tipo_leche' => 'Tipo de Leche',
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
