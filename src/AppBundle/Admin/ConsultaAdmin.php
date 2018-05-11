<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ConsultaAdmin extends AbstractAdmin {

    private $id_asignatura = 12;
    
    // método utilizado para mostrar el nombre de usuario en el breadcrums
    public function toString($object) {
        return 'Consulta';
    }

    public function createQuery($context = 'list') { 

        $request = $this->getRequest(); 
        $id = $request->query->get('id'); 

        if (isset($id)) $this->id_asignatura = $id;

        $query = parent::createQuery($context); 
        $rootAlias = $query->getRootAliases()[0]; 

        $query->leftJoin($rootAlias.'.seccion', 's')
            ->leftJoin('s.temario', 't')
                ->where($query->expr()->eq('t.asignatura', ':asignatura')) 
        ->setParameter('asignatura', $this->id_asignatura)
        ;

        return $query; 
    }

    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();

        return $instance;
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

            ->with('Respuestas', ['class' => 'col-md-12'])
                ->add('respuestas', 'sonata_type_collection', [], [ 
                    'edit' => 'inline', 
                    'inline' => 'table', 
                ])  
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
        /*
            ->add('estado', ChoiceType::class, array( 
                'choices'  => array( 
                    'PENDIENTE' => 'PENDIENTE', 
                    'CONSTESTADA' => 'CONTESTADA', 
                ))
            )            
*/            
            ->add('estado')
            ->add('fecha')            
            ->add('usuario.username')
            ->add('seccion.titulo')
            ->add('seccion.temario.titulo');
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
        ;
    }
}