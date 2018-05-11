<?php

namespace SeguridadBundle\Admin;

use Knp\Menu\ItemInterface as MenuItemInterface;
use AppBundle\Admin\ServicioAdmin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsuarioAdmin extends AbstractAdmin {
    
    private $encoder;

    public function __construct($code, $class, $baseControllerName, UserPasswordEncoderInterface $encoder) {
        parent::__construct($code, $class, $baseControllerName);
        $this->encoder = $encoder;
    }

    // método utilizado para mostrar el nombre de usuario en el breadcrums
    public function toString($object) {
        return $object->getUsername();
    }

    // nuevas rutas
    protected function configureRoutes(RouteCollection $collection) {
        $collection->add('cambiarClave', $this->getRouterIdParameter().'/clave');
        $collection->remove('delete');
    }

    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();
        $instance->setIsactive(true);

        return $instance;
    }

    // método que configura las acciones que se ejecutan para todos los objetos de la lista
    public function configureBatchActions($actions) {

        if ($this->hasRoute('edit') && $this->isGranted('ROLE_ADMIN')) {
            $actions['desactivar'] = [
                'label' => 'Desactivar',
                'ask_confirmation' => false
            ];
        }

        return $actions;
    }

    // función que ejecuta código antes de crear un usuario nuevo
    public function prePersist($usuario) {    
        $encoded = $this->encoder->encodePassword($usuario, $usuario->getPassword());
        $usuario->setPassword($encoded);
    }
   
    public function createQuery($context = 'list') {

        // recuperamos el id del padre (que es el usuario) 
        $admin = $this->isChild() ? $this->getParent() : $this; 
        $id = $admin->getRequest()->get('id');      

        // obtenemos la query actual y el rootalias        
        $query = parent::createQuery($context);
        $rootAlias = $query->getRootAliases()[0];

        if (isset($id) && ($admin instanceof ServicioAdmin)) {
            // creamos la consulta para listas los usuarios de un servicio dado
            $query->leftJoin($rootAlias.'.matriculas_servicios', 'ms')
                ->where($query->expr()->eq('ms.servicio', ':servicio'))
                ->setParameter('servicio', $id)
            ;
        }

        return $query;  
    }    

    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null) {
        
        // si se está mostrando el listado de usuarios, no procede añadir facturas
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) { return; }

        // obteniendo el id del usuario
        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');
        
        if ($this->isChild()) {
            // Añadiendo el propio usuario para poder editarlo
            $menu->addChild('Usuario', [
                'uri' => $admin->generateUrl('edit', ['id' => $id])
            ]);
        }

        // Añadiendo mátriculas de servicios como hijo de usuario
        $menu->addChild('Servicios', [ 
            'uri' => $admin->generateUrl('admin.matricula_servicios.list', ['id' => $id]) 
        ]);         

        // Añadiendo mátriculas de temarios como hijo de usuario
        $menu->addChild('Temarios', [ 
            'uri' => $admin->generateUrl('admin.matricula_temarios.list', ['id' => $id]) 
        ]);         

        // Añadiendo mátriculas de secciones como hijo de usuario
        $menu->addChild('Secciones', [ 
            'uri' => $admin->generateUrl('admin.matricula_secciones.list', ['id' => $id]) 
        ]);         

        // Añadiendo facturas como hijo de usuario y su id 
        $menu->addChild('Facturas', [
            'uri' => $admin->generateUrl('admin.factura.list', ['id' => $id])
        ]);        

    }     

    protected function configureFormFields(FormMapper $formMapper) {

        $request = $this->getRequest(); 
        
        $formMapper
            ->with('Nuevo usuario', ['class' => 'col-md-6'])
                ->add('username', TextType::class)
                ->add('email', TextType::class)
                ->add('rol', ChoiceType::class, array(
                    'choices'  => array(
                        'ROLE_ANONIMO' => 'ROLE_ANONIMO',
                        'ROLE_ALUMNO' => 'ROLE_ALUMNO',
                        'ROLE_PROFESOR' => 'ROLE_PROFESOR',
                        'ROLE_ADMIN' => 'ROLE_ADMIN',
                    ))
                )
                ->add('nombre', TextType::class)
                ->add('apellidos', TextType::class)
                ->add('isActive', CheckboxType::class, array('required' => false))
                ->add('universidad', TextType::class)
            ->end();
        
        // Name field will be added only when create an item
        if ($this->isCurrentRoute('create')) {
            $formMapper->with('Clave de usuario', ['class' => 'col-md-6'])
                ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'La confirmación de la clave no coincide',
                    'options' => ['attr' => array('class' => 'password-field', 'minlength' => 4, 'maxlength' => 8)],
                    'required' => true,
                    'first_options'  => ['label' => 'Clave'],
                    'second_options' => ['label' => 'Confirmar clave'],
                ))
            ->end();
        }

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('rol')
            ->add('nombre')
            ->add('apellidos')
            ->add('isActive')
            ->add('universidad')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add('rol')
            ->add('nombre')
            ->add('apellidos')
            ->add('isActive')
            ->add('universidad')
            ->add('clave', 'string', [
                'template' => 'SeguridadBundle:Admin:cambiar_clave.html.twig'
            ])
        ;
    }
}