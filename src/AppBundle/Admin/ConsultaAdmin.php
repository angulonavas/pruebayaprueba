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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ConsultaAdmin extends AbstractAdmin {

    protected $parentAssociationMapping = 'asignatura';

    // método utilizado para mostrar el nombre de usuario en el breadcrums
    public function toString($object) {
        $consulta = $this->getSubject();
        return substr($consulta->getDescripcion(), 0, 20);
    }
/*
    public function createQuery($context = 'list') { 

        $request = $this->getRequest(); 
        $id = $request->query->get('id'); 

        $query = parent::createQuery($context); 
        $rootAlias = $query->getRootAliases()[0]; 

        if (isset($id)) {
            $this->id_asignatura = $id;

            $query->leftJoin($rootAlias.'.seccion', 's')
                ->leftJoin('s.temario', 't')
                    ->where($query->expr()->eq('t.asignatura', ':asignatura')) 
            ->setParameter('asignatura', $id)
            ;
        }

        return $query; 
    }
*/

    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null) { 
            
        // si se está mostrando el listado, no procede añadir nada al menú
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) { return; } 
        
        // obteniendo el id del objeto padre (si existe, si no, el id del objeto actual)
        $admin = $this->isChild() ? $this->getParent() : $this; 
        $id = $admin->getRequest()->get('id'); 

        // obteniendo el objeto actual
        $consulta = $this->getSubject();

        // Añadiendo la ruta a la lista de consultas de la asignatura abierta
        // Utilizamos route en vez de uri porque es una ruta fuera de la relación padre -> hijo
        $menu->addChild('Consultas de '.$consulta->getAsignatura()->getTitulo(), [
            'route' => 'admin_app_asignatura_consulta_list',
            'routeParameters' => [
                'id' => $consulta->getAsignatura()->getId()
            ]
        ]);

        // Añadiendo la ruta al hijo del objeto actual
        $menu->addChild('Respuestas', [ 
            'uri' => $admin->generateUrl('admin.respuesta.list', ['id' => $id]) 
        ]);      
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Consultas al profesor', ['class' => 'col-md-12'])
                ->add('estado', ChoiceType::class, array( 
                    'choices'  => array( 
                        'PENDIENTE' => 'PENDIENTE', 
                        'CONSTESTADA' => 'CONTESTADA', 
                    ))
                )
                ->add('fecha', DateTimeType::class)
                ->add('descripcion', TextareaType::class, [ 
                    'attr' => array('cols' => '100', 'rows' => '10') 
                ])
            ->end()          
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('estado', null, [], 'choice', [ 
                'choices'  => [
                    'PENDIENTE' => 'PENDIENTE', 
                    'CONSTESTADA' => 'CONTESTADA', 
                ]
            ])            
            ->add('fecha')            
            ->add('usuario.username')
            ->add('seccion.titulo')
            ->add('seccion.temario.titulo')
/*            
            ->add('with_open_comments', 'doctrine_orm_callback', array(
                'callback' => function($queryBuilder, $alias, $field, $value) {
                    if (!$value['value']) {
                        return;
                    }
                    $queryBuilder->leftJoin($alias.'.seccion', 's')
                        ->leftJoin('s.temario', 't')
                        ->andWhere('t.asignatura = :asignatura') 
                        ->setParameter('asignatura', $this->id_asignatura)
                    ;

                    return true;
                },
                'field_type' => 'checkbox'
            ))
*/            
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('estado')
            ->add('fecha', null, [
                'format' => 'd-m-Y H:i'
            ])            
            ->add('usuario.username')
            ->add('seccion.titulo')
            ->add('seccion.temario.titulo')
            ->add('respuestas', 'string', [
                'template' => ':Admin:boton_respuestas.html.twig'
            ])            
        ;
    }
}