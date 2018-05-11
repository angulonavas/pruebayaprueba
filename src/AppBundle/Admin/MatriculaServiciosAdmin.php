<?php

namespace AppBundle\Admin;

use Knp\Menu\ItemInterface as MenuItemInterface; 

use AppBundle\Admin\ServicioAdmin;
use SeguridadBundle\Admin\UsuarioAdmin;

use Sonata\AdminBundle\Admin\AbstractAdmin; 
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class MatriculaServiciosAdmin extends AbstractAdmin {

    // método utilizado para mostrar el nombre de usuario en el breadcrums
    public function toString($object) {
        return 'Matrícula';
    }

    // el nombre de la ruta es 'verUsuarios'
    protected function configureRoutes(RouteCollection $collection) { 
        $collection->add('verUsuarios', $this->getRouterIdParameter().'/usuarios'); 
    }

    public function createQuery($context = 'list') { 

        // recuperamos el id del padre (que es el usuario) 
        $admin = $this->isChild() ? $this->getParent() : $this; 
        $id = $admin->getRequest()->get('id');        

        // recuperamos la query
        $query = parent::createQuery($context); 
        $rootAlias = $query->getRootAliases()[0]; 

        if (isset($id) && ($admin instanceof UsuarioAdmin)) {
            // sólo mostraremos las matrículas del usuario
            $query->where($query->expr()->eq($rootAlias.'.usuario', ':usuario'))
                ->setParameter('usuario', $id);
     
        } elseif (isset($id) && ($admin instanceof ServicioAdmin)) {
            // sólo mostraremos las matrículas del servicio
            $query->where($query->expr()->eq($rootAlias.'.servicio', ':servicio'))
                ->setParameter('servicio', $id);
        }

        return $query; 
    } 

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Usuarios matriculados en el servicio', ['class' => 'col-md-6'])
                ->add('usuario.username', TextType::class)
                ->add('servicio.titulo', TextType::class)
                ->add('fecha', DatetimeType::class)
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('usuario.username')
            ->add('servicio.titulo')
            ->add('fecha', null, [
                'format' => 'd-m-Y H:i'
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {

        $padre = ($this->isChild()) ? $this->getParent() : $this;

        if ($padre instanceof UsuarioAdmin) $padre = 'Usuario';
        elseif ($padre instanceof ServicioAdmin) $padre = 'Servicio';

        if ($padre == 'Usuario') $listMapper->addIdentifier('servicio.titulo');
        elseif ($padre == 'Servicio') $listMapper->addIdentifier('usuario.username');

        $listMapper->add('fecha', null, ['format' => 'd-m-Y H:i']);
    }
}