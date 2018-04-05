<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;

use AppBundle\Service\AccesoAulas;

class AularioController extends Controller {
    
    /**
     * @Route("/asignaturas/{asignatura}", name="contenido_asignatura")
     */
    public function cargar_asignatura_infoAction(Request $request, $asignatura) {
        
        $asignatura = [
            'titulo' => $asignatura,
            'descripcion' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
        ];
        return $this->render('Asignatura/info_asignatura.html.twig', [
            'asignatura' => $asignatura
        ]);
    }

    /**
     * @Route("/asignaturas/{asignatura}/videos/{categoria}", name="contenido_videos_categoria")
     */
    public function cargar_videos_categoriaAction(Request $request, $asignatura, $categoria) {
        
        $asignatura = [
            'titulo' => $asignatura,
            'descripcion' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'categoria' => $categoria,
            'videos' => [
                [
                    'id' => 2,
                    'descripcion' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit', 
                    'url' => 'ZystMG-NmGY?showinfo=0&modestbranding=1',
                ], 
                [
                    'id' => 3,
                    'descripcion' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam',
                    'url' => 'ZystMG-NmGY?showinfo=0&modestbranding=1',
                ], 
                [
                    'id' => 4,
                    'descripcion' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo', 
                    'url' => 'ZystMG-NmGY?showinfo=0&modestbranding=1',
                ], 
            ] 
        ];

        return $this->render('Asignatura/videos.html.twig', [
            'asignatura' => $asignatura
        ]);
    }

    /**
     * @Route("/asignaturas/{asignatura}/documentos", name="contenido_documentos_asignatura")
     */
    public function cargar_documentos_asignaturaAction(Request $request, $asignatura) {

        $asignatura = [
            'titulo' => $asignatura,
            'descripcion' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 
        ];
        return $this->render('Asignatura/documentos.html.twig', [
            'asignatura' => $asignatura
        ]);
    }

    /**
     * @Route("/asignaturas/{asignatura}/documentos/subir", name="contenido_subir_documento")
     */
    public function subir_documentoAction(Request $request) {
        echo 'cargando nuevo documento...';
        // replace this example code with whatever you need
        return $this->render('Asignatura/documentos.html.twig', []);
    }    

    /**
     * @Route("/asignaturas/{asignatura}/{temario}", name="contenido_indice_temario")
     */
    public function cargar_indice_temarioAction(Request $request, $asignatura, $temario) {
        
        $asignatura = [
            'titulo' => $asignatura,
            'descripcion' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 
            'temario' => $temario,
        ];

        return $this->render('Asignatura/temario.html.twig', [
            'asignatura' => $asignatura
        ]);
    }   
     
    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/guardar", name="contenido_guardar_guia")
     */
    public function guardar_cookie_guiaAction(Request $request) {
        
        $acceso = $acceso_aulas->acceso($asignatura, $temario, $seccion);

        if ($acceso) {        
            return $this->render('Aula/seccion.html.twig', []);
        } else {
            return $this->render('@Seguridad/acceso_denegado.html.twig', []);   
        }            
    }    

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/examen/evaluar", name="contenido_evaluar_examen")
     */
    public function evaluar_examenAction(Request $request) {
        
        $acceso = $acceso_aulas->acceso($asignatura, $temario, $seccion);

        if ($acceso) {        
            return $this->render('Aula/examen.html.twig', []);
        } else {
            return $this->render('@Seguridad/acceso_denegado.html.twig', []);   
        }            
    }       

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/consultas/enviar", name="contenido_enviar_consulta")
     */
    public function enviar_consultaAction(Request $request) {
        
        $acceso = $acceso_aulas->acceso($asignatura, $temario, $seccion);

        if ($acceso) {        
            $examen = false;
            if ($examen) return $this->render('Aula/examen.html.twig', []);
            else return $this->render('Secciones/ID9991.html.twig', []);
        } else {
            return $this->render('@Seguridad/acceso_denegado.html.twig', []);   
        }
    }

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}/consultas/{id}", name="contenido_cargar_consultas")
     */
    public function cargar_consultas_seccionAction(Request $request) {

        $acceso = $acceso_aulas->acceso($asignatura, $temario, $seccion);

        if ($acceso) {
            $examen = false;
            if ($examen) return $this->render('Aula/examen.html.twig', []);
            else return $this->render('Secciones/ID9991.html.twig', []);
        } else {
            return $this->render('@Seguridad/acceso_denegado.html.twig', []);   
        }
    }

    /**
     * @Route("/aula/{asignatura}/{temario}/secciones", name="contenido_cargar_secciones")
     */
    public function cargar_secciones_temarioAction(Request $request, AccesoAulas $acceso_aulas, $asignatura, $temario) {
        
        $acceso = $acceso_aulas->acceso($asignatura, $temario);

        if ($acceso) {

            $asignatura = [
                'titulo' => $asignatura,
                'temario' => [
                    'titulo' => $temario,
                ]
            ];

            return $this->render('Aula/acceso_secciones.html.twig', [
                'asignatura' => $asignatura
            ]);

        } else {
            return $this->render('@Seguridad/acceso_denegado.html.twig', []);   
        }            
    } 

    /**
     * @Route("/aula/{asignatura}/{temario}/{seccion}", name="contenido_cargar_seccion")
     */
    public function cargar_seccion_temarioAction(Request $request, AccesoAulas $acceso_aulas, $asignatura, $temario, $seccion) {

        $acceso = $acceso_aulas->acceso($asignatura, $temario, $seccion);

        if ($acceso) {
        
            $asignatura = [
                'titulo' => $asignatura,
                'temario' => [
                    'titulo' => $temario,
                    'seccion' => $seccion,
                ]
            ];

            $examen = false;
            
            if ($examen) {
                return $this->render('Aula/examen.html.twig', [
                    'asignatura' => $asignatura
                ]);

            } else {
                return $this->render('Secciones/ID9991.html.twig', [
                    'asignatura' => $asignatura
                ]);
            }

        } else {
            return $this->render('@Seguridad/acceso_denegado.html.twig', []);   
        }            
    }

    /**
     * @Route("/aula/{asignatura}/temarios", name="contenido_cargar_temarios")
     */
    public function cargar_temarios_asignaturaAction(Request $request, AccesoAulas $acceso_aulas, $asignatura) {
        
        $acceso = $acceso_aulas->acceso($asignatura);

        if ($acceso) {

            $asignatura = [
                'titulo' => $asignatura,
            ];        
            return $this->render('Aula/acceso_temarios.html.twig', [
                'asignatura' => $asignatura]);
        } else {
            return $this->render('@Seguridad/acceso_denegado.html.twig', []);   
        }
    }   

}
