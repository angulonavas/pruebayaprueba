<?php

namespace AppBundle\Admin;

use SeguridadBundle\Entity\Usuario;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class FacturaAdmin extends AbstractAdmin {
    
    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();
        $instance->setPublicado(true);

        return $instance;
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Facturas', ['class' => 'col-md-6'])
                ->add('codigo', TextType::class)
                ->add('fecha', DateTimeType::class)
                ->add('iva', TextType::class)
                ->add('total', TextType::class)
                ->add('usuario', EntityType::class, [
                    'class' => Usuario::class,
                    'choice_label' => 'username',
                ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('codigo')
            ->add('fecha')
            ->add('iva')
            ->add('total')
            ->add('usuario.username')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('codigo')
            ->addIdentifier('fecha')
            ->addIdentifier('iva')
            ->addIdentifier('total')
            ->addIdentifier('usuario.username')
        ;
    }
}
