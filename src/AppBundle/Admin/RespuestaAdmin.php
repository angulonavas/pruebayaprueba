<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Consulta;
use SeguridadBundle\Entity\Usuario;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RespuestaAdmin extends AbstractAdmin {
    
    protected $parentAssociationMapping = 'consulta';

    // método utilizado para mostrar el nombre de usuario en el breadcrums
    public function toString($object) {
        return 'Respuesta';
    }

    // método llamado automáticamente para dar valores por defecto a las nuevas entidades   
    public function getNewInstance() {
        $instance = parent::getNewInstance();
        $container = $this->getConfigurationPool()->getContainer(); 

        $usuario = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $instance->setUsuario($usuario);

        return $instance;
    }

    public function postPersist($respuesta) {
        
        // obtenemos la consulta
        $consulta = $respuesta->getConsulta();
        $consulta->setEstado('CONTESTADA');
        
        // persistimos los cambios en la BBDD
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $em->persist($consulta);
        $em->flush();
    }    

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->add('descripcion', TextareaType::class, [ 
                'attr' => array('cols' => '100', 'rows' => '10') 
            ])                    
            ->add('usuario', EntityType::class, [ 
                'class' => Usuario::class, 
                'choice_label' => 'username',
                'disabled' => true
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper;        
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('fecha', null, [
                'format' => 'd-m-Y H:i'
            ])
        ;
    }
}