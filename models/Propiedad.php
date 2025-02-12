<?php

namespace Model;

use Intervention\Image\Colors\Hsv\Channels\Value;

class Propiedad extends ActiveRecord
{
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];  // Este arreglo nos permitira mapear y unir los atributos


    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null; // Todo lo que este como public, vamos a hacer referencia a el como $this->variable
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }
        if (strlen($this->titulo) > 45) { // Cambia 50 al límite definido en la base de datos
            self::$errores[] = "El título no puede exceder los 45 caracteres";
        }

        if (!$this->precio) {
            self::$errores[] = "El precio es obligatorio";
        }
        if ($this->precio > 99999999.99) {
            self::$errores[] = "El precio no debe ser mayor a 99,999,999.99";
        }

        if (strlen($this->descripcion) < 50) {  // Con strlen podemos hacer una comprobacion para la descripcion, en este caso debe contener como minimo 50 caracteres
            self::$errores[] = "La descripción es obligatoria y debe contener al menos 50 caracteres";
        }

        if (!$this->habitaciones) {
            self::$errores[] = "El número de habitaciones es obligatorio";
        }

        if (!$this->wc) {
            self::$errores[] = "El número de baños es obligatorio";
        }

        if (!$this->estacionamiento) {
            self::$errores[] = "El número de lugares de Estacionamiento es obligatorio";
        }

        if (!$this->vendedores_id) {
            self::$errores[] = "Elige un Vendedor";
        }
        if (!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }

        return self::$errores;
    }
}
