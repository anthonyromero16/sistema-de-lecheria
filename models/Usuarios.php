<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property resource|null $imagen
 * @property string|null $celular
 * @property string $contrasena
 * @property string $email
 * @property string|null $rol
 * @property string|null $fecha_creado
 * @property string|null $fecha_actualizado
 *
 * @property Animales[] $animales
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{

    /**
     * ENUM field values
     */
    const ROL_ADMIN = 'admin';
    const ROL_USUARIO = 'usuario';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'imagen', 'celular'], 'default', 'value' => null],
            [['rol'], 'default', 'value' => 'usuario'],
            [['nombre', 'contrasena', 'email'], 'required'],
            [['descripcion', 'imagen', 'rol'], 'string'],
            [['fecha_creado', 'fecha_actualizado'], 'safe'],
            [['nombre', 'email'], 'string', 'max' => 100],
            [['celular'], 'string', 'max' => 20],
            [['contrasena'], 'string', 'max' => 255],
            ['rol', 'in', 'range' => array_keys(self::optsRol())],
            [['email'], 'unique'],
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
            'celular' => 'Celular',
            'contrasena' => 'Contrasena',
            'email' => 'Email',
            'rol' => 'Rol',
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
        return $this->hasMany(Animales::class, ['id_usuario' => 'id']);
    }


    /**
     * column rol ENUM value labels
     * @return string[]
     */
    public static function optsRol()
    {
        return [
            self::ROL_ADMIN => 'admin',
            self::ROL_USUARIO => 'usuario',
        ];
    }

    /**
     * @return string
     */
    public function displayRol()
    {
        return self::optsRol()[$this->rol];
    }

    /**
     * @return bool
     */
    public function isRolAdmin()
    {
        return $this->rol === self::ROL_ADMIN;
    }

    public function setRolToAdmin()
    {
        $this->rol = self::ROL_ADMIN;
    }

    /**
     * @return bool
     */
    public function isRolUsuario()
    {
        return $this->rol === self::ROL_USUARIO;
    }

    public function setRolToUsuario()
    {
        $this->rol = self::ROL_USUARIO;
    }

    public static function findIdentity($id)
{
    return self::findOne($id);
}

public static function findIdentityByAccessToken($token, $type = null)
{
    return null;
}

public function getId()
{
    return $this->id;
}

public function getAuthKey()
{
    return null;
}

public function validateAuthKey($authKey)
{
    return false;
}

}
