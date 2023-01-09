<?php

namespace MVC;

class Router {

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn) {
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->rutasPOST[$url] = $fn;
    }
    
   public function comprobarRutas () {

        session_start();

        $auth = $_SESSION['login'] ?? null;

        // Arreglo de rutas protegidas
        $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar', '/entradas/crear', '/entradas/actualizar', '/entradas/eliminar'];

        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];
        
        
       if($metodo === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? null;
       } else {
            $fn = $this->rutasPOST[$urlActual] ?? null;
       }

       // Proteger las rutas
       if(in_array($urlActual, $rutas_protegidas) && !$auth) {
            header('Location: /');
       }

       if($fn) {
        // La url existe y hay una funcion asociada
        call_user_func($fn, $this);

       } else {
        echo "Pagina no encontrada";
       }
   }

   ///Muestra una vista
   public function render ($view, $datos = []) {

        foreach($datos as $key => $value) {
            $$key = $value;
        }

        // Almacenamiento en memoria durante un momento...
        ob_start();
        include __DIR__ . "/views/$view.php";

        //Limpia el buffer de memoria
        $contenido = ob_get_clean();
        include __DIR__ . '/views/layout.php';
   }
}