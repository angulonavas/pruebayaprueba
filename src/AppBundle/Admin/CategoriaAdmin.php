<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Asignatura;

use Knp\Menu\ItemInterface as MenuItemInterface; 

use Sonata\AdminBundle\Admin\AbstractAdmin; 
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoriaAdmin extends AbstractAdmin {
    
    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();

        return $instance;
    }

    // método utilizado para mostrar el nombre de usuario en el breadcrums
    public function toString($object) {
        return $object->getDescripcion();
    }

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

    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null) { 

        // obteniendo el id del usuario 
        $request = $this->getRequest();
        $id2 = $request->query->get('id');        

        // Añadiendo la edición del propio admin al menú
        $menu->addChild('Lista de categorías 2', [ 
            'uri' => $this->generateUrl('admin.categoria.list', ['id' => $id2]) 
        ]);  
        
        // si se está mostrando el listado de usuarios, no procede añadir facturas 
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) { return; } 
        
        // obteniendo el id del usuario 
        $admin = $this->isChild() ? $this->getParent() : $this; 
        $id = $admin->getRequest()->get('id'); 

        // Añadiendo la edición del propio admin al menú
        $menu->addChild('Categoría', [ 
            'uri' => $admin->generateUrl('admin.categoria.edit', ['id' => $id]) 
        ]);  

        // Añadiendo facturas como hijo de usuario y su id 
        $menu->addChild('Videos', [ 
            'uri' => $admin->generateUrl('admin.video.list', ['id' => $id]) 
        ]);      
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Foros generales', ['class' => 'col-md-6'])
                ->add('orden', TextType::class)
                ->add('descripcion', TextType::class)
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
            ->add('asignatura.titulo')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('orden')
            ->addIdentifier('descripcion')
            ->addIdentifier('asignatura.titulo')
        ;
    }
}