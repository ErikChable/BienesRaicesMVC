<?php

namespace MVC;

class Router
{

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn)
    { // URL y funcion asociada a esa URL
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn)
    { // URL y funcion asociada a esa URL
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas()
    {
        session_start();

        $auth = $_SESSION['login'] ?? null;

        // Arreglo de rutas protegidas
        $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar', '/blogs/crear', '/blogs/actualizar', '/blogs/eliminar'];

        $urlActual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/'; // Obtiene la URL actual
        $metodo = $_SERVER['REQUEST_METHOD'];

        if ($metodo === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        // Proteger las rutas
        if (in_array($urlActual, $rutas_protegidas) && !$auth) { // in_array permite revisar un elemento en un array
            header('Location: /');
        }

        if ($fn) {
            // La URL existe y hay una funcion asociada
            call_user_func($fn, $this); // Mandamos llamar a ese metodo que este asociado con las rutas
        } else {
            echo "Pagina No Encontrada";
        }
    }

    // Muestra una vista
    public function render($view, $datos = [])
    {

        foreach ($datos as $key => $value) {
            $$key = $value; //  Crea una nueva variable con el nombre almacenado en $key y le asigna el valor correspondiente de $value.
        }

        ob_start(); // Almacenamiento en memoria durante un momento...
        include __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); // Limpia el Buffer

        include __DIR__ . "/views/layout.php";
    }
}
