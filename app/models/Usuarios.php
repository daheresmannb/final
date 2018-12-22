<?php

class Usuarios extends \Phalcon\Mvc\Model {
    public $id;
    public $nombre;
    public $apellido;
    public $correo;
    public $password;
    public $rol_id;

    public function initialize() {
        $this->setSchema("final");
        $this->setSource("usuarios");
        $this->belongsTo(   // relacion con la tabla roles
            'rol_id', 
            'models\Roles', 
            'id', 
            ['alias' => 'Roles']
        );
    }

    public function getSource() {
        return 'usuarios';
    }

    public static function find($parameters = null) {
        return parent::find($parameters);
    }

    public static function Encontrar($correo) {
        $params = [
            'columns'    => '*',
            'conditions' => "correo = ?1",
            'bind'       => [
                1 => $correo
            ]
        ];
        return parent::find($params);
    }

    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }
}