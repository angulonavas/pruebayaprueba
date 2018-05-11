<?php

namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SeccionAdminController extends Controller {

	public function abrirPreguntasAction() {
		$seccion = $this->admin->getSubject();

		//return new RedirectResponse($this->generateUrl('admin_app_factura_list'));
		return new RedirectResponse($this->generateUrl('admin_app_pregunta_examen_list', [
			'id' => $seccion->getId()
		]));
	}

	public function abrirTeoriaAction(Request $request) {

/*
<h1>Sección S1</h1>
<p>Vamos a meter contenido</p>
*/

		// recuperamos la sección y otros recursos
		$seccion = $this->admin->getSubject();
        $dir_asignatura = 'asignatura'.$seccion->getTemario()->getAsignatura()->getId();
        $dir_temario = 'temario'.$seccion->getTemario()->getId();
        $guardado = false; // - el mensaje de éxito está en blanco.
        $fs = new Filesystem(); // cargamos el sistema de ficheros
        //$url_directorio = 'secciones/'.$dir_asignatura.'/'.$dir_temario;
        $url_directorio = '../app/Resources/views/Secciones/'.$dir_asignatura.'/'.$dir_temario;
            // al indicar 'secciones/' lo estamos creando en la raiz del directorio /web del sistema
            // si quisiéramos que se creara con url absolutas deberiamos indicar '/url/secciones'
        $nom_fichero = $url_directorio.'/'.'seccion'.$seccion->getId().'.html';
        $teoria = '<h1>Contenido teórico de la sección '.$seccion->getTitulo().'</h1>';
        $ficheros = null; // se inicializa el vector de ficheros encontrados por finder

        if (!$fs->exists($url_directorio)) {

        	// creamos el directorio
            $fs->mkdir($url_directorio);

            // creando el fichero
        	$fs->dumpFile($nom_fichero, $teoria);

        } else {

	    	// si ya existe el directorio, buscamos el fichero
	        $finder = new Finder();
	        $finder->in($url_directorio);
	        $ficheros = iterator_to_array($finder->files()->name('id'.$seccion->getId().'.html'));

	        // si existe el fichero leemos el contenido
	        if (count($ficheros)) {
	        	foreach ($ficheros as $file) $teoria = $file->getContents();
	        
	        // si no existe el fichero lo creamos
	        } else $fs->dumpFile($nom_fichero, $teoria);
	        
        }

        if ($request->request->get('teoria')) {
        	
			// si se acaba de enviar la nueva teoría por $_POST se escribe en el fichero
        	$teoria = $request->request->get('teoria');
        	$fs->dumpFile($nom_fichero, $teoria);

        	// incluyendo mensaje de éxito
        	$guardado = 'El contenido de la sección se ha guardado con éxito';       	
                
        } else {
			
			// si no se ha enviado nada todavía, se busca el fichero y se lee del contenido del fichero
            $ficheros = iterator_to_array($finder->files()->name('id'.$seccion->getId().'.html'));
        	foreach ($ficheros as $file) $teoria = $file->getContents();
        }

        return $this->render('/Admin/teoria_edit.html.twig', [
            'action' => 'clave',
            'object' => $seccion,
            'teoria' => $teoria,
            'guardado' => $guardado
        ]);
	}	
}
