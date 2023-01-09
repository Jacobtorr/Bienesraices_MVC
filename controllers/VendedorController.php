<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController {
    // PANEL DE ADMINISTRACION SECCION CREAR
    public static function crear (Router $router) {

        //Consulta para obtener todos los vendedores
        $vendedor = new Vendedor;

        // Arreglo con mensajes de errores
        $errores = Vendedor::getErrores();

        // Ejecutar el codigo una vez que el usuario envie el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Crea una nueva instancia //
            $vendedor = new Vendedor($_POST['vendedor']);

            // Validar que no haya campos vacios
            $errores = $vendedor->validar();
            
            if (empty($errores)) {
                // Guarda en la BD
            $vendedor->guardar(); 
            }
        }

        $router->render('vendedores/crear', [
            
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    // PANEL DE ADMINISTRACION SECCION ACTUALIZAR
    public static function actualizar (Router $router) {
        $id = validarORedireccionar('/public/admin');
        $vendedor = Vendedor::find($id);

        // Arreglo con mensajes de errores
        $errores = Vendedor::getErrores();

        // Metodo POST para actualizar datos
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Asignar los atributos
            $args = $_POST['vendedor'];
            $vendedor->sincronizar($args);
    
            // Validacion 
            $errores = $vendedor->validar();
            
            // Revisar que el array de errores este vacio
              if (empty($errores)) {
                $vendedor->guardar();
            }    
        }

        $router->render('vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
      
    }

    public static function eliminar () {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                
            // Validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
                
            if($id) {
                $tipo = $_POST['tipo'];
                if (validarTipoContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();  
                } 
            }
        }
    }
}