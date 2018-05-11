<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Asignatura;
use AppBundle\Entity\Temario;

use Knp\Menu\ItemInterface as MenuItemInterface;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Sonata\AdminBundle\Form\Type\ModelType;

class TemarioAdmin extends AbstractAdmin {
    
    protected $parentAssociationMapping = 'asignatura';

    // consulta que se lanzará para configurar el listado 
    public function createQuery($context = 'list') { 

        // recuperamos el id del padre (que es el asignatura) 
        $admin = $this->isChild() ? $this->getParent() : $this; 
        $id = $admin->getRequest()->get('id');        

        // sólo mostraremos las facturas del asignatura 
        $query = parent::createQuery($context); 
        $rootAlias = $query->getRootAliases()[0]; 

        // modificamos la query
        $query->where($query->expr()->eq($rootAlias.'.asignatura', ':asignatura')) 
            ->setParameter('asignatura', $id); 
    
        return $query; 
    }

    public function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null) {
            
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

        $temario = $this->getSubject();

        $menu->addChild('Temarios', [
            'uri' => $admin->generateUrl('admin.temario.list', ['id' => $temario->getAsignatura()->getId()])
        ]); 

        // Añadiendo la edición del propio admin al menú
        $menu->addChild('Temario', [ 
            'uri' => $admin->generateUrl('admin.temario.edit', ['id' => $id]) 
        ]); 

        $menu->addChild('Secciones', [
            'uri' => $admin->generateUrl('admin.seccion.list', ['id' => $id])
        ]);      

        $menu->addChild('Matrículas', [
            'uri' => $admin->generateUrl('admin.matricula_temarios.list', ['id' => $id])
        ]);      

    }
    
    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();
        $instance->setPublicado(true);

        return $instance;
    }

    public function toString($object) {
        // shown in the breadcrumb on the create view
        return $object instanceof Temario ? $object->getTitulo() : 'Temario'; 
    }    

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Anuncios para el tablón', ['class' => 'col-md-6'])
                ->add('orden', TextType::class)
                ->add('titulo', TextType::class)
                ->add('descripcion', TextAreaType::class)
            ->end()
            ->with('Precio', ['class' => 'col-md-6'])
                ->add('precio', TextType::class)
                ->add('iva', TextType::class)
                ->add('publicado', CheckboxType::class, array('required' => false))
                ->add('asignatura', ModelType::class, [
                    'class' => Asignatura::class,
                    'property' => 'titulo',
                ])
            ->end();

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('orden')
            ->add('titulo')
            ->add('descripcion')
            ->add('precio')
            ->add('iva')            
            ->add('publicado')
            ->add('asignatura', null, [], EntityType::class, [
                'class'    => Asignatura::class,
                'choice_label' => 'titulo',
            ])            
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->add('orden')
            ->addIdentifier('titulo')
            ->add('precio')
            ->add('iva')
            ->add('publicado')
            ->add('asignatura.titulo')
        ;
    }
}
