<?php

namespace Controllers;

use MVC\Router;
use Model\Admin;

class LoginController
{

    public static function login(Router $router)
    {
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Admin($_POST);

            $errores = $auth->validar();

            if (empty($errores)) {
                // Verificar si el usuario existe
                $resultado = $auth->existeUsuario();

                if (!$resultado) {
                    // Verificar si el usuario existe o no
                    $errores = Admin::getErrores();
                } else {
                    // Verificar el Password
                    $autenticado = $auth->comprobarPassword($resultado);

                    if ($autenticado) { // Si el usuario esta autenticado
                        // Autenticar al usuario
                        $auth->autenticar();
                    } else { // Password Incorrecto (Mensaje de Error)
                        $errores = Admin::getErrores();
                    }
                }
                // Verificar el password


                // Autenticar el usuario
            }
        }

        $router->render('auth/login', [
            'errores' => $errores
        ]);
    }

    public static function logout()
    {
        session_start();

        $_SESSION = [];

        header('Location: /');
    }
}
