<?php

namespace AppBundle\Menu;

use AppBundle\Entity\Asignatura;

use Knp\Menu\FactoryInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MenuSonata implements ContainerAwareInterface {
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options) {
        
        $menu = $factory->createItem('Administración');
        $menu->addChild('Usuarios', array('route' => 'admin_seguridad_usuario_list'));
        $menu->addChild('Facturas', array('route' => 'admin_app_factura_list'));
        $menu->addChild('Anuncios', array('route' => 'admin_app_anuncio_list'));
        $menu->addChild('Foros generales', array('route' => 'admin_app_foro_general_list'));
        $menu->addChild('Frases', array('route' => 'admin_app_frase_list'));
        $menu->addChild('Servicios', array('route' => 'admin_app_servicio_list'));
        
        $asignaturas = $this->container->get('doctrine')->getManager()->getRepository(Asignatura::class)->buscarTodo();

        foreach ($asignaturas as $asignatura) {
            $menu->addChild($asignatura->getTitulo(), [
                'route' => 'admin_app_asignatura_edit',
                'routeParameters' => [
                    'id' => $asignatura->getId()
                ]
            ]);        
            
            $menu[$asignatura->getTitulo()]->addChild('Documentos', [
                'route' => 'admin_app_asignatura_documento_list',
                'routeParameters' => array('id' => $asignatura->getId())
            ]);

            $menu[$asignatura->getTitulo()]->addChild('Foros', [
                'route' => 'admin_app_foro_asignatura_list',
                'routeParameters' => array('id' => $asignatura->getId())
            ]);

            $menu[$asignatura->getTitulo()]->addChild('categories', [
                'route' => 'admin_app_categoria_list',
                'routeParameters' => array('id' => $asignatura->getId())
            ]);

            $menu[$asignatura->getTitulo()]->addChild('Consultas', [
                'route' => 'admin_app_asignatura_consulta_list',
                'routeParameters' => array('id' => $asignatura->getId())
            ]);

            $menu[$asignatura->getTitulo()]->addChild('Temarios', [
                'route' => 'admin_app_temario_list',
                'routeParameters' => ['id' => $asignatura->getId()]
            ]);                    

        }

        $menu->addChild('lista_asignaturas', array('route' => 'admin_app_asignatura_list'));

        return $menu;
    }
}