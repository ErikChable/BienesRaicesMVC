<?php

namespace Model;

class Admin extends ActiveRecord
{
    // Base de Datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar()
    {
        if (!$this->email) {
            self::$errores[] = 'El Email es obligatorio';
        }

        if (!$this->password) {
            self::$errores[] = 'El Password es obligatorio';
        }

        // if (strlen($this->password) < 8) {
        //     self::$errores[] = 'El Password debe tener al menos 8 caracteres';
        // }

        return self::$errores;
    }

    public function existeUsuario()
    {
        // Revisar si un usuario existe o no

        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if (!$resultado->num_rows) {
            self::$errores[] = "El usuario no existe";
            return;
        }
        return $resultado;
    }

    public function comprobarPassword($resultado)
    {
        $usuario = $resultado->fetch_object();

        $autenticado = password_verify($this->password, $usuario->password); // Este codigo sirve para verificar si el password esta bien
        // Como primer parametro toma el password que vamos a comparar, y el segundo es el password que esta en la BD

        if (!$autenticado) { // Si no esta autenticado
            self::$errores[] = 'El Password es Incorrecto';
        }

        return $autenticado;
    }

    public function autenticar()
    {
        session_start();

        // Llenar el arreglo de session
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');
    }
}
