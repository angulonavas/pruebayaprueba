<?php 

namespace AppBundle\Twig;

class AppRuntime {
    
    public function __construct() {
        // this simple example doesn't define any dependency, but in your own
        // extensions, you'll need to inject services using this constructor
    }

    public function nombre_claseFilter($objeto) {

        $clase = explode('\\', get_class($objeto));
        $clase = $clase[count($clase)-1];

        return $clase;     
    }

    public function fecha_normalFilter($fecha) {

        $fecha = $fecha->format('d-m-Y H:i');

        return $fecha;
    }    

    public function formato_euroFilter($cantidad) {

        $cantidad = number_format($cantidad, 2, ",", ".").' €';

        return $cantidad;
    }     
}