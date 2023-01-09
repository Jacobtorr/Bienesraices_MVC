<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Model\Entrada;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController {
    // PANEL DE ADMINISTRACION SECCION CREAR
    public static function index(Router $router) {
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $entradas = Entrada::all();
        // Muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores,
            'entradas' => $entradas
        ]);
    }

    // PANEL DE ADMINISTRACION SECCION CREAR
    public static function crear (Router $router) {

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();

        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Crea una nueva instancia 
            $propiedad = new Propiedad($_POST['propiedad']);
                
            // Generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            
            // Setear la imagen
            // Realiza un resize a la imagen con intervention
            if($_FILES['propiedad']['tmp_name']['imagen']) { 
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }

            // Validar
            $errores = $propiedad->validar();
            
            if (empty($errores)) {
                // Crear carpeta para subir imagenes
                if(!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
            
                //Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                // Guarda en la BD
                $propiedad->guardar(); 
            }

        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    // PANEL DE ADMINISTRACION SECCION ACTUALIZAR
    public static function actualizar (Router $router) {

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /');
        }
        
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();

        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        // Metodo POST para actualizar datos
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Asignar los atributos
            $args = $_POST['propiedad'];
            $propiedad->sincronizar($args);
    
            // Validacion 
            $errores = $propiedad->validar();
    
            // Subida de archivos
            // Generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    
            if($_FILES['propiedad']['tmp_name']['imagen']) { 
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
            
            // Revisar que el array de errores este vacio
              if (empty($errores)) {
                if($_FILES['propiedad']['tmp_name']['imagen']) {
                    // Almacenar imagen
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
                $propiedad->guardar();
            }    
        }

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
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
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();  
                } 
            }
        }
    }
}