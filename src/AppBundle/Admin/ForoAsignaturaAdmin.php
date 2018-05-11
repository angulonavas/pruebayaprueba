<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Asignatura;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ForoAsignaturaAdmin extends AbstractAdmin {
    
    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();

        $request = $this->getRequest();
        $id = $request->query->get('id');
        $instance->setAsignatura($id);

        return $instance;
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
            ->with('Foros de la asignatura', ['class' => 'col-md-6'])
                ->add('orden', TextType::class)
                ->add('descripcion', TextType::class)
                ->add('url', TextType::class)
                ->add('asignatura', EntityType::class, [
                    'class' => Asignatura::class,
                    'choice_label' => 'titulo',
                ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('orden')
            ->add('descripcion')
            ->add('url')
            ->add('asignatura.titulo')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('orden')
            ->addIdentifier('descripcion')
            ->add('url', 'url', [
                'template' => ':Admin:url_foro.html.twig'
            ])            
            ->addIdentifier('asignatura.titulo')
        ;
    }
}
