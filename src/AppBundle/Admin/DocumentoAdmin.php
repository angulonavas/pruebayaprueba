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

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Documentos de la asignatura', ['class' => 'col-md-6'])
                ->add('descripcion', TextType::class)
                ->add('tipo', TextType::class)
                ->add('fichero', TextType::class)
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
                ->add('usuario', EntityType::class, [
                    'class' => Usuario::class,
                    'choice_label' => 'username',
                ])                
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
            ->addIdentifier('tipo')
            ->addIdentifier('fichero')
            ->addIdentifier('publicado')
            ->addIdentifier('prioridad')
            ->addIdentifier('asignatura.titulo')
            ->addIdentifier('usuario.username')
        ;
    }
}