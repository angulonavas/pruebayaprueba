<?php

namespace AppBundle\Admin;

use Knp\Menu\ItemInterface as MenuItemInterface; 

use Sonata\AdminBundle\Admin\AbstractAdmin; 
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ServicioAdmin extends AbstractAdmin {

    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();
        $instance->setPublicado(true);
        $instance->setPrioridad(2);

        return $instance;
    }

    public function toString($object) {
        return $object->getTitulo();
    }

    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null) {
        
        // si se está mostrando el listado de usuarios, no procede añadir facturas
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) { return; }

        // obteniendo el id del usuario
        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

         // Añadiendo matrícuas como hijo de servicio y su id 
       $menu->addChild('Usuarios matriculados', [
            'uri' => $admin->generateUrl('admin.usuario.list', ['id' => $id])
        ]);

        // Añadiendo matrícuas como hijo de servicio y su id 
  
        $menu->addChild('Matrículas', [
            'uri' => $admin->generateUrl('admin.matricula_servicios.list', ['id' => $id])
        ]);
  
    } 

    // devuelve el vector de prioridades
    function getPrioridades() {
        return array( 0 => 'Muy alta', 1 => 'Alta', 2 => 'Media', 3 => 'Baja');
    }

    // crea el vector de prioridades
    function setPrioridades() {
        return array('Muy alta' => 0, 'Alta' => 1, 'Media' => 2, 'Baja' => 3);
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Servicios del catálogo', ['class' => 'col-md-6'])
                ->add('publicado', CheckboxType::class, array('required' => false))
                ->add('titulo', TextType::class)
                ->add('descripcion', TextareaType::class)
                ->add('fechaIni', DateTimeType::class)
                ->add('fechaFin', DateTimeType::class)
                ->add('prioridad', ChoiceType::class, array(
                    'choices'  => $this->setPrioridades())
                )
                ->add('precio', TextType::class)
                ->add('iva', TextType::class)
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('publicado')
            ->add('titulo')
            ->add('descripcion')
            ->add('fechaIni')
            ->add('fechaFin')
            ->add('prioridad')
            ->add('precio')
            ->add('iva')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        setlocale(LC_TIME, "es_ES");
        $listMapper
            ->add('publicado', null, [
                'header_style' => 'width: 5%',
                'editable' => true
            ])
            ->addIdentifier('titulo')
            ->add('fechaIni', null, [
                'format' => 'd-m-Y H:i'
            ])
            ->add('fechaFin', null, [
                'format' => 'd-m-Y H:i'
            ])
            ->add('prioridad', 'choice', ['choices' => $this->getPrioridades()])
            ->add('precio', 'currency', [
                'template' => ':Admin:formato_euro.html.twig', 
                'campo' => 'precio'
            ])
            ->add('iva', 'percent', [
                'template' => ':Admin:formato_porcentaje.html.twig',
                'campo' => 'iva'
            ])
        ;
    }
}