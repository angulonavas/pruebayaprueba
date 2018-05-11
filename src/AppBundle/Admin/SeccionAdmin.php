<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Temario;
use AppBundle\Entity\Seccion;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SeccionAdmin extends AbstractAdmin {
    
    protected $parentAssociationMapping = 'temario';

    // método utilizado para mostrar el nombre de usuario en el breadcrums
    public function toString($object) {
        return $object->getTitulo();
    }

    protected function configureRoutes(RouteCollection $collection) {
        $collection->add('abrirTeoria', $this->getRouterIdParameter().'/teoria');
    }
    
    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();

        return $instance;
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Secciones del temario', ['class' => 'col-md-6'])
                ->add('titulo', TextType::class)
                ->add('descripcion', TextType::class)
                ->add('orden', TextType::class)
                ->add('teorica', CheckboxType::class, array('required' => false))
                ->add('publicado', CheckboxType::class, array('required' => false))
                ->add('precio', TextType::class)
                ->add('iva', TextType::class)
                ->add('temario', EntityType::class, [
                    'class' => Temario::class,
                    'choice_label' => 'titulo',
                ])                
                ->add('anterior', EntityType::class, [
                    'class' => Seccion::class,
                    'choice_label' => 'titulo',
                ])         
                ->add('posterior', EntityType::class, [
                    'class' => Seccion::class,
                    'choice_label' => 'titulo',
                ])
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('titulo')
            ->add('descripcion')
            ->add('orden')
            ->add('teorica')
            ->add('publicado')
            ->add('precio')
            ->add('iva')
            ->add('temario.titulo')
            ->add('anterior.titulo')
            ->add('posterior.titulo')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('titulo')
            ->addIdentifier('orden')
            ->addIdentifier('teorica')
            ->addIdentifier('publicado')
            ->add('precio', null, ['editable' => true])
            ->addIdentifier('iva')
            ->addIdentifier('anterior.titulo')
            ->addIdentifier('posterior.titulo')
            ->add('teoria', 'string', [
                'template' => ':Admin:boton_teoria.html.twig'
            ])            
            ->add('examen', 'string', [
                'template' => ':Admin:boton_preguntas.html.twig'
            ])
            ->add('matriculas', 'string', [
                'template' => ':Admin:boton_matriculas_secciones.html.twig'
            ])            
        ;
    }
}