<?php

namespace AppBundle\Twig;

use AppBundle\Twig\AppRuntime;

class AppExtension extends \Twig_Extension {
    
    public function getFilters() {
        
        return array(        
            new \Twig_SimpleFilter('nombre_clase', array(AppRuntime::class, 'nombre_claseFilter')),
            new \Twig_SimpleFilter('fecha_normal', array(AppRuntime::class, 'fecha_normalFilter')),
            new \Twig_SimpleFilter('formato_euro', array(AppRuntime::class, 'formato_euroFilter')),
        );
    }
}