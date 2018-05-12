<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Asignatura;
use AppBundle\Service\FileUploader;

use Knp\Menu\ItemInterface as MenuItemInterface; 

use SeguridadBundle\Entity\Usuario;

use Sonata\AdminBundle\Admin\AbstractAdmin; 
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DocumentoAdmin extends AbstractAdmin {
    
    protected $parentAssociationMapping = 'asignatura';

    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();
        $instance->setPublicado(true); 
        $instance->setPrioridad(2); 

        return $instance;
    }

    // crea la url hacia el documento
    public function getUrl() {
        // pendiente de hacer
        return $this;
    }

    // método utilizado para mostrar el nombre de usuario en el breadcrums
    public function toString($object) {
        $consulta = $this->getSubject();
        return substr($consulta->getDescripcion(), 0, 20);
    }    

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Documentos de la asignatura', ['class' => 'col-md-6'])
                ->add('descripcion', TextType::class)
                ->add('publicado', CheckboxType::class)
                ->add('prioridad', ChoiceType::class, array(
                    'choices'  => array(
                        'Muy alta' => 0,
                        'Alta' => 1,
                        'Media' => 2,
                        'Baja' => 3,
                    ))
                )                
                ->add('asignatura', EntityType::class, [
                    'class' => Asignatura::class,
                    'choice_label' => 'titulo',
                ])
                ->add('usuario', EntityType::class, 
                    [
                        'class' => Usuario::class,
                        'choice_label' => 'username'
                    ],
                    [
                        'admin_code' => 'admin.usuario',
                    ]
                )          
                ->add('file', FileType::class, [
                    'required' => false,
                    'label' => false,
                    'attr' => array('class' => 'btn btn-primary btn-block'),
                    'validation_groups' => ['create']
                ])                
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('descripcion')
            ->add('tipo')
            ->add('publicado')
            ->add('prioridad')
            ->add('asignatura.titulo')
            ->add('usuario.username')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('descripcion')
            ->add('tipo')
            //->add('Fichero', 'url')
                        
            ->add('Fichero', 'url', [
                'template' => ':Admin:url_documento.html.twig'
            ])
                       
            ->add('publicado')
            ->add('prioridad')
            ->add('asignatura.titulo')
            ->add('usuario.username')
        ;
    }
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null) { 
            
        // si se está mostrando el listado, no procede añadir nada al menú
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) { return; } 
        
        // obteniendo el id del objeto padre (si existe, si no, el id del objeto actual)
        $admin = $this->isChild() ? $this->getParent() : $this; 
        $id = $admin->getRequest()->get('id'); 

        // obteniendo el objeto actual
        $documento = $this->getSubject();

        // Añadiendo la ruta a la lista de consultas de la asignatura abierta
        // Utilizamos route en vez de uri porque es una ruta fuera de la relación padre -> hijo
        $menu->addChild('Consultas de '.$documento->getAsignatura()->getTitulo(), [
            'route' => 'admin_app_asignatura_documento_list',
            'routeParameters' => [
                'id' => $documento->getAsignatura()->getId()
            ]
        ]);
    }

    // método de configuración de la validación del formulario
    // este método sobreesecribe el básico para crear grupos de validación
    // a partir de aquí ya se puede definir en la entidad Documento las validaciones deseadas para los grupos deseados
    public function getFormBuilder() {

        // si no existe el id de documento es porque desde el formulario se está intentando crear. 
        //      Crearemos el grupo adminCreate
        // si existe id es porque desde el formulario se está intentando actualizar. 
        //      Crearemos el grupo adminEdit
        if (is_null($this->getSubject()->getId())) {
            // creamos el grupo adminCreate
            $this->formOptions = array('validation_groups' => array('adminCreate'));
        } else {
            // creamos el grupo adminEdit
            $this->formOptions = array('validation_groups' => array('adminEdit'));
        }
        $formBuilder = parent::getFormBuilder();
        return $formBuilder;
    }    

    // método que se lanza previamente al momento en que se desea persisitir un objeto documento en la BBDD
    public function prePersist($documento) {
        $this->manageFileUpload($documento);
    }

    // método que se lanza previamente al momento en que se desea actualizar un objeto documento en la BBDD
    public function preUpdate($documento) {
        $this->manageFileUpload($documento);
    }

    // este método es necesario para poder actualizar documentos en los que únicamente cambie el fichero en sí, por 
    // ejemplo si aparece una nueva actualización que queremos subir.
    // la idea es probocar que se lancen los eventos prePersist y preUpdate del DocumentoUploadListener.
    // Para ello el truco está en actualizar un campo sin mucho sentido como es Updated el cual contiene una fecha 
    // con el momento en que se va a proceder a actualizar. Como el Documento ya cambia en algo, se lanzan los eventos
    private function manageFileUpload($documento) {
        if ($documento->getFile()) {
            $documento->refreshUpdated();
        }        
    }   
}