<?php

namespace Controllers;

use MVC\Router;
use Model\Entrada;
use Intervention\Image\ImageManagerStatic as Image;

class EntradaController {

    public static function crear (Router $router) {
       $entrada = new Entrada;

       // Arreglo con mensaje de errores
       $errores = Entrada::getErrores();

       if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Crear nueva instancia
            $entrada = new Entrada($_POST['entrada']);

            // Genera un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            // Setear la imagen
            // Realizar resize con Intervention/Image
            if($_FILES['entrada']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['entrada']['tmp_name']['imagen'])->fit(800,600);
                $entrada->setImagen($nombreImagen);
            }

            //Validar
            $errores = $entrada->validar();

            if(empty($errores)) {
                //Crea carpeta para subir imagenes
                if(!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
                
                // Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                // Guardar en la BD
                $entrada->guardar();
            }
       }

       $router->render('entradas/crear', [
            'entrada' => $entrada,
            'errores' => $errores
       ]);
    }
    
    public static function actualizar (Router $router) {
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /');
        }
        
        $entrada = Entrada::find($id);

        // Arreglo con mensajes de errores
        $errores = Entrada::getErrores();

        // Metodo POST para actualizar datos
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Asignar los atributos
            $args = $_POST['entrada'];
            $entrada->sincronizar($args);
    
            // Validacion 
            $errores = $entrada->validar();
    
            // Subida de archivos
            // Generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    
            if($_FILES['entrada']['tmp_name']['imagen']) { 
                $image = Image::make($_FILES['entrada']['tmp_name']['imagen'])->fit(800,600);
                $entrada->setImagen($nombreImagen);
            }
            
            // Revisar que el array de errores este vacio
              if (empty($errores)) {
                if($_FILES['entrada']['tmp_name']['imagen']) {
                    // Almacenar imagen
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
                $entrada->guardar();
            }    
        }

        $router->render('entradas/actualizar', [
            'entrada' => $entrada,
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
                    $entrada = Entrada::find($id);
                    $entrada->eliminar();  
                } 
            }
        }
    
    }
}