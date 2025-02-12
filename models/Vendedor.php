<?php

namespace Model;

class Vendedor extends ActiveRecord
{
    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];  // Este arreglo nos permitira mapear y unir los atributos

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null; // Todo lo que este como public, vamos a hacer referencia a el como $this->variable
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$errores[] = "El nombre es obligatorio";
        }

        if (!$this->apellido) {
            self::$errores[] = "El apellido es obligatorio";
        }

        if (!$this->telefono) {
            self::$errores[] = "El teléfono es obligatorio";
        }

        if (strlen($this->telefono) > 10) {
            self::$errores[] = "El teléfono no puede exceder los 10 digitos";
        }

        if (!preg_match('/[0-9]{10}/', $this->telefono)) { // Expresion fija para que solo acepte 10 numeros del 0 al 9
            self::$errores[] = "Formato no Válido";
        }

        return self::$errores;
    }
}
