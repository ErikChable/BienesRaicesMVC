<?php

namespace Model;

class Blog extends ActiveRecord
{
    // Base de Datos
    protected static $tabla = 'blogs';
    protected static $columnasDB = ['id', 'titulo', 'fecha', 'autor', 'detalles', 'imagen'];

    public $id;
    public $titulo;
    public $fecha;
    public $autor;
    public $detalles;
    public $imagen;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->fecha = date('Y/m/d');
        $this->autor = $args['autor'] ?? '';
        $this->detalles = $args['detalles'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
    }

    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = "Debes de añadir un titulo";
        }
        if (strlen($this->titulo) > 45) { // Cambia 50 al límite definido en la base de datos
            self::$errores[] = "El título no puede exceder los 45 caracteres";
        }

        if (!$this->autor) {
            self::$errores[] = "Debes añadir el nombre del autor";
        }

        if (strlen($this->detalles) < 50) {  // Con strlen podemos hacer una comprobacion para la descripcion, en este caso debe contener como minimo 50 caracteres
            self::$errores[] = "Los detalles son obligatorios y deben contener al menos 50 caracteres";
        }

        if (!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }

        return self::$errores;
    }
}
