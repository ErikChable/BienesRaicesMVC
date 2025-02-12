<?php

namespace Controllers;

use MVC\Router;
use Model\Blog;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;

class BlogController
{
    public static function index(Router $router)
    {
        $blogs = Blog::all();
        $resultado = $_GET['resultado'] ?? null;

        $router->render('blogs/index', [
            'resultado' => $resultado,
            'blogs' => $blogs
        ]);
    }

    public static function crear(Router $router)
    {
        // Arreglo con mensajes de error
        $errores = Blog::getErrores();
        $blog = new Blog;

        // Metodo POST para crear
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Creamos una instancia
            $blog = new Blog($_POST['blog']);
            // GENERAR UN NOMBRE UNICO
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            // Setear la imagen
            // Realiza un resize de la imagen con intervention  
            if ($_FILES['blog']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $imagen = $manager->read($_FILES['blog']['tmp_name']['imagen'])->cover(800, 600);
                $blog->setImagen($nombreImagen);
            }

            $errores = $blog->validar();

            if (empty($errores)) {
                /* SUBIDA DE ARCHIVOS */
                // CREAR CARPETA
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }

                // Guarda la imagen en el servidor
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);

                $blog->guardar();
            }
        }

        $router->render('blogs/crear', [
            'errores' => $errores,
            'blog' => $blog,

        ]);
    }

    public static function actualizar(Router $router)
    {
        $id = validarORedireccionar('/admin');
        $blog = Blog::find($id);
        $errores = Blog::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Asignar atributos
            $args = $_POST['blog'];
            $blog->sincronizar($args);

            // Validacion
            $errores = $blog->validar(); // Esto nos permite que al momento de actualizar una propiedad, ningun campo quede vacio

            // Subida de archivos
            // GENERAR UN NOMBRE UNICO
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            if ($_FILES['blog']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $imagen = $manager->read($_FILES['blog']['tmp_name']['imagen'])->cover(800, 600);
                $blog->setImagen($nombreImagen);
            }
            if (empty($errores)) {
                // Almacenar la imagen
                if ($_FILES['blog']['tmp_name']['imagen']) {
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }

                $blog->guardar();
            }
        }

        $router->render('/blogs/actualizar', [
            'blog' => $blog,
            'errores' => $errores
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validar ID
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $tipo = $_POST['tipo'];
                if (validarTipoContenido($tipo)) {
                    $blog = Blog::find($id);
                    $blog->eliminar();
                }
            }
        }
    }
}
