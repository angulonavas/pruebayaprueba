<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Categoria;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VideoAdmin extends AbstractAdmin {
    
    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();

        return $instance;
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Foros generales', ['class' => 'col-md-6'])
                ->add('descripcion', TextType::class)
                ->add('url', TextType::class)
                ->add('publicado', CheckboxType::class, array('required' => false))
                ->add('categoria', EntityType::class, [
                    'class' => Categoria::class,
                    'choice_label' => 'descripcion',
                ])                
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('descripcion')
            ->add('url')
            ->add('publicado')
            ->add('categoria.descripcion')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('descripcion')
            ->addIdentifier('url')
            ->addIdentifier('publicado')
            ->addIdentifier('categoria.descripcion')
        ;
    }
}