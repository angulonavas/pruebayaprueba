<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Categoria;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VideoAdmin extends AbstractAdmin {

    // método utilizado para mostrar el nombre de usuario en el breadcrums
    public function toString($object) {
        return $object->getDescripcion();
    }

    // consulta que se lanzará para configurar el listado 
    public function createQuery($context = 'list') { 

        // recuperamos el id del padre (que es el categoria) 
        $admin = $this->isChild() ? $this->getParent() : $this; 
        $id = $admin->getRequest()->get('id');        

        // sólo mostraremos las facturas del categoria 
        $query = parent::createQuery($context); 
        $rootAlias = $query->getRootAliases()[0]; 

        // modificamos la query
        $query->where($query->expr()->eq($rootAlias.'.categoria', ':categoria')) 
            ->setParameter('categoria', $id); 
    
        return $query; 
    } 

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
                ->add('prioridad', ChoiceType::class, array(
                    'choices'  => array(
                        'Muy alta' => 0,
                        'Alta' => 1,
                        'Media' => 2,
                        'Baja' => 3,
                    ))
                ) 
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('descripcion')
            ->add('url')
            ->add('publicado')
            ->add('categoria.descripcion')
            ->add('prioridad')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('descripcion')
            ->add('url')
            ->add('publicado')
            ->add('categoria.descripcion')
            ->add('_action', null, [ 'actions' => [
                'delete' => []
            ]])
            ->add('prioridad')
        ;
    }
}