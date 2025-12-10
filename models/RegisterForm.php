<?php

namespace app\models;

use yii\base\Model;

class RegisterForm extends Model
{
    public $nombre;
    public $email;
    public $celular;
    public $contrasena;
    public $confirmar_contrasena;

    public function rules()
    {
        return [
            [['nombre', 'email', 'celular', 'contrasena', 'confirmar_contrasena'], 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 100],
            ['email', 'unique', 'targetClass' => Usuarios::class, 'message' => 'Este correo ya está registrado.'],
            ['celular', 'string', 'max' => 20],
            ['confirmar_contrasena', 'compare', 'compareAttribute' => 'contrasena', 'message' => 'Las contraseñas no coinciden.'],
        ];
    }

    public function attributeLabels()
{
    return [
        'nombre' => 'Nombre',
        'email' => 'Correo electrónico',
        'celular' => 'Celular',
        'contrasena' => 'Contraseña',
        'confirmar_contrasena' => 'Confirmar contraseña',
    ];
}
}
