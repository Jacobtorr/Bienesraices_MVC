<?php

namespace Model;

class Entrada extends ActiveRecord {

    protected static $tabla = 'entradas';
    protected static $columnasDB = ['id', 'titulo', 'imagen', 'descripcion',  'creado'];

    public $id;
    public $titulo;
    public $imagen;
    public $descripcion;
    public $creado;


    public function __construct($args = [])
    {   
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->creado = date('Y/m/d');
    }

    public function validar() {
        if(!$this->titulo) {
            self::$errores[] = "Debes anadir un titulo";
        }
        
        if(strlen ($this->descripcion) < 100) {
            self::$errores[] = "La descripcion es obligatoria y debe tener al menos 100 caracteres";
        }

         if (!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }
 
        return self::$errores;

    }
}