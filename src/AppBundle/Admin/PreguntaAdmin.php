<?php

namespace AppBundle\Admin;

use Knp\Menu\ItemInterface as MenuItemInterface;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PreguntaAdmin extends AbstractAdmin {

    // método utilizado para mostrar el nombre de usuario en el breadcrums
    public function toString($object) {
        return 'Pregunta';
    }

    // consulta que se lanzará para configurar el listado 
    public function createQuery($context = 'list') { 

        // recuperamos el id del padre (que es el usuario) 
        $admin = $this->isChild() ? $this->getParent() : $this; 
        $id = $admin->getRequest()->get('id');        

        // sólo mostraremos las facturas del usuario 
        $query = parent::createQuery($context); 

        if ($admin->getRequest()->get('id')) {
            $rootAlias = $query->getRootAliases()[0]; 
            $query->where($query->expr()->eq($rootAlias.'.seccion', ':seccion')) 
                ->setParameter('seccion', $id); 
        }
    
        return $query; 
    }

    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();
        $instance->setPublicado(true);

        return $instance;
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Anuncios para el tablón', ['class' => 'col-md-12'])
                ->add('orden', TextType::class)
                ->add('descripcion', TextType::class)
            ->end()

            ->with('Opciones', ['class' => 'col-md-12'])
                ->add('opciones', 'sonata_type_collection', [], [
                    'edit' => 'inline',
                    'inline' => 'table',
                ])                
            ->end();
    }

    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null) {
        
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

        $pregunta = $this->getSubject();


        // Añadiendo la edición del propio admin al menú
        $menu->addChild('Temarios', [ 
                'route' => 'admin_app_temario_list',
                'routeParameters' => []
        ]); 

        $menu->addChild('Temario', [
            'route' => 'admin_app_temario_edit',
            'routeParameters' => [
                'id' => $pregunta->getSeccion()->getTemario()->getId()
            ]
        ]);    

        $menu->addChild('Secciones', [
            'route' => 'admin_app_temario_seccion_list',
            'routeParameters' => ['id' => $pregunta->getSeccion()->getTemario()->getId()]
        ]);

        $menu->addChild('Seccion', [
            'route' => 'admin_app_temario_seccion_edit',
            'routeParameters' => [
                'id' => $pregunta->getSeccion()->getTemario()->getId(),
                'childId' => $pregunta->getSeccion()->getId()
            ]
        ]);           

        $menu->addChild('Preguntas', [
            'route' => 'admin_app_pregunta_examen_list',
            'routeParameters' => ['id' => $pregunta->getSeccion()->getId()]
        ]);        
    } 

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('orden')
            ->add('descripcion')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('orden')
            ->addIdentifier('descripcion')
        ;
    }
}