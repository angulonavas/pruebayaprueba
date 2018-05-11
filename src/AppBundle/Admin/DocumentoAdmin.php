<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Asignatura;
use SeguridadBundle\Entity\Usuario;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DocumentoAdmin extends AbstractAdmin {
    
    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();

        return $instance;
    }

    // crea la url hacia el documento
    public function getUrl() {
        // pendiente de hacer
        return $this;
    }

    // método utilizado para mostrar el nombre de usuario en el breadcrums
    public function toString($object) {
        return $object->getDescripcion();
    }    

    public function createQuery($context = 'list') {

        $request = $this->getRequest();
        $id = $request->query->get('id');

        $query = parent::createQuery($context);
        $rootAlias = $query->getRootAliases()[0];
        $query->where($query->expr()->eq($rootAlias.'.asignatura', ':asignatura'))
            ->setParameter('asignatura', $id)
        ; 
        
        return $query;
    } 

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Documentos de la asignatura', ['class' => 'col-md-6'])
                ->add('descripcion', TextType::class)
                ->add('tipo', TextType::class)
                ->add('publicado', CheckboxType::class, array('required' => false))
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
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('descripcion')
            ->add('tipo')
            ->add('fichero')
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
            ->add('Fichero', 'url', [
                'template' => ':Admin:url_documento.html.twig'
            ])
            ->add('publicado')
            ->add('prioridad')
            ->add('asignatura.titulo')
            ->add('usuario.username')
        ;
    }
}