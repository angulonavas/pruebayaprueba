<?php

// src/AppBundle/EventListener/BrochureUploadListener.php
namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

use AppBundle\Entity\Documento;
use AppBundle\Service\FileUploader;

class DocumentoUploadListener
{
    private $uploader;

    // cargamos el servicio que hemos creado para trabajar con uploadiong de ficheros
    public function __construct(FileUploader $uploader) {
        $this->uploader = $uploader;
    }
    
    // previamente a guardar un fichero en la base de datos se laza automáticamente este evento que obtiene la entidad
    // Documento y seguidamente carga el fichero que llega adjunto desde el cliente    
    public function prePersist(LifecycleEventArgs $args) {
        $documento = $args->getEntity();
        $this->uploadFile($documento);
    }

    // previamente a guardar un fichero en la base de datos se laza automáticamente este evento que obtiene la entidad
    // Documento y seguidamente carga el fichero que llega adjunto desde el cliente    
    public function preUpdate(PreUpdateEventArgs $args) {
        $documento = $args->getEntity();
        $this->uploadFile($documento);
    }

    // trabajando el fichero cargado desde el formulario del cliente (NO desde la BBDD)
    // este método es llamado desde los eventos prePersist y preUpdate.
    // la intención del método es cargar el fichero adjuntado por el usuario y obtener el nombre del mismo.
    private function uploadFile($documento) {

        // si la entiad que ha lanzado el evento no es un documento no haremos nada
        if (!$documento instanceof Documento) { return; }

        // obtenemos el fichero
        $file = $documento->getFile();

        // si el fichero es un UploadedFile, es decir, si no es una cadena, asignaremos al documento el nombre del fichero
        if ($file instanceof UploadedFile) {

            // guardamos el fichero en su ubicación y obtenemos el nombre del fichero
            $fileName = $this->uploader->upload($file, $documento->getAsignatura());

            // asignamos al documento el tipo o extensión
            $documento->setTipo($this->uploader->getExtension());

            // asignamos al documento el nombre del fichero
            $documento->setFilename($fileName);
        }
    }

    // este evento se lanza cuando se carga un documento desde la BBDD.
    // lo que hacemos es cargar el fichero en base al nombre obtenido de la BBDD y asignar el fichero en sí al documento
    public function postLoad(LifecycleEventArgs $args) {

        // obtenemos la entidad que ha provocado el evento
        $documento = $args->getEntity();

        // si la entidad no es documento nos saltamos el evento
        if (!$documento instanceof Documento) { return; }

        // obtenemos el nombre del fichero que viene de la BBDD.
        if ($fileName = $documento->getFilename()) {

            // obtenemos la url en la que está el fichero almacenado            
            $url = $this->uploader->getDirectorio($documento->getAsignatura()).'/'.$fileName.'.'.$documento->getTipo();
            
            // cargamos el fichero y lo pasamos al documento. Ahora ya no posee un nombre de fichero sino el fichero en sí
            $documento->setFile(new UploadedFile($url, $fileName));
        }       
    }         
}