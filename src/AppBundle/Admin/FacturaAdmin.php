<?php

namespace AppBundle\Admin;

use SeguridadBundle\Admin\UsuarioAdmin;
use SeguridadBundle\Entity\Usuario;

use Knp\Menu\ItemInterface as MenuItemInterface;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class FacturaAdmin extends AbstractAdmin {
    
    // método utilizado para mostrar el código de factura en el breadcrums
    public function toString($object) {
        return $object->getCodigo();
    }

    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();
        $instance->setPublicado(true);

        return $instance;
    }

    // configuración de rutas
    protected function configureRoutes(RouteCollection $collection) {
        $collection->remove('edit')->remove('delete')->remove('create')->remove('batch');
        //$collection->clearExcept(array('list', 'show'));
    }

    // consulta que se lanzará para configurar el listado
    public function createQuery($context = 'list') {

        // recuperamos el id del padre (que es el usuario)
        $admin = $this->isChild() ? $this->getParent() : $this;
        $query = parent::createQuery($context);

        if ($admin->getRequest()->get('id')) { 

            $id = $admin->getRequest()->get('id');

            // sólo mostraremos las facturas del usuario
            $rootAlias = $query->getRootAliases()[0];
            $query->where($query->expr()->eq($rootAlias.'.usuario', ':usuario'))
                ->setParameter('usuario', $id); 
        }
        
        return $query;
    }    

    public function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null) {
            
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

        $factura = $this->getSubject();

        $menu->addChild('Conceptos', [
            'uri' => $admin->generateUrl('admin.concepto.list', ['id' => $id])
        ]);      
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

    protected function configureListFields(ListMapper $listMapper, AdminInterface $childAdmin = null) {
        $listMapper
            ->add('codigo')
            ->add('fecha')
            ->add('total', 'currency', [
                'template' => ':Admin:formato_euro.html.twig',
                'campo' => 'total'
            ])
            ->add('iva', 'currency', [
                'template' => ':Admin:formato_euro.html.twig',
                'campo' => 'iva'
            ])             
            ->add('usuario.username')
            ->add('_action', null, [ 'actions' => [ 
                'show' => [], 
            ]]);

        $padre = ($this->isChild()) ? $this->getParent() : $this;
        $padre = ($padre instanceof UsuarioAdmin) ? 'Usuario' : 'Factura';

        if ($padre == 'Usuario') {
            $listMapper->add('conceptos', 'string', [
                'template' => ':Admin:boton_conceptos.html.twig'
            ]);
        }
    }

    protected function configureShowFields(ShowMapper $showMapper) {    
        $showMapper
            ->add('codigo')
            ->add('fecha', null, [
                'format' => 'd-m-Y H:i'
            ])            
            ->add('total')
            ->add('iva')
            ->add('usuario.username')
        ;
    }
}
