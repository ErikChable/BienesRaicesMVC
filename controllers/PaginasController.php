<?php

namespace Controllers;

use Model\Blog;
use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{
    public static function index(Router $router)
    {
        $propiedades = Propiedad::get(3);
        $blogs = Blog::get(2);
        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio,
            'blogs' => $blogs
        ]);
    }

    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros');
    }

    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router)
    {
        $id = validarORedireccionar('/propiedades');
        // Buscar la propiedad por su ID
        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }

    public static function blog(Router $router)
    {
        $blogs = Blog::all();

        $router->render('paginas/blog', [
            'blogs' => $blogs
        ]);
    }

    public static function entrada(Router $router)
    {
        // Validamos el ID
        $id = validarORedireccionar('/blog');
        // Obtenemos los datos de la propiedad
        $blog = Blog::find($id);

        $router->render('paginas/entrada', [
            'blog' => $blog
        ]);
    }

    public static function contacto(Router $router)
    {

        $mensaje = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto'];

            // Crear una instancia de PHPMailer
            $mail = new PHPMailer();

            // Configurar SMTP
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST']; // Servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASSWORD'];

            // Configurar contenido del Email
            $mail->setFrom($_ENV['EMAIL_USER']);
            $mail->addAddress($_ENV['EMAIL_USER'], 'BienesRaices.com');
            $mail->Subject = 'Tienes un nuevo mensaje';

            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Definir el contenido
            $contenido = '<html>';
            $contenido .= '<body>';
            $contenido .= '<p> Tienes un nuevo mensaje </p>';
            $contenido .= '<p> Nombre:  ' . $respuestas['nombre'] . ' </p>';

            // Enviar de forma condicional los campo de email o telefono
            if ($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p> Eligio ser contactado por Teléfono: </p>';
                $contenido .= '<p> Teléfono:  ' . $respuestas['telefono'] . ' </p>';
                $contenido .= '<p> Fecha Contacto:  ' . $respuestas['fecha'] . ' </p>';
                $contenido .= '<p> Hora:  ' . $respuestas['hora'] . ' </p>';
            } else {
                // Es email, entonces agregamos el campo de email
                $contenido .= '<p> Eligio ser contactado por email: </p>';
                $contenido .= '<p> Email: ' . $respuestas['email'] . ' </p>';
            }

            $contenido .= '<p> Mensaje:  ' . $respuestas['mensaje'] . ' </p>';
            $contenido .= '<p> Vende o Compra:  ' . $respuestas['tipo'] . ' </p>';
            $contenido .= '<p> Precio o Presupuesto:  $' . $respuestas['precio'] . ' </p>';

            $contenido .= '</body>';
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es un texto alternativo sin HTML';

            // Enviar el email
            if ($mail->send()) {
                $mensaje = "Mensaje enviado Correctamente";
                header('Refresh: 3; url = /');
            } else {
                $mensaje = "El mensaje no se pudo enviar...";
            }
        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}
