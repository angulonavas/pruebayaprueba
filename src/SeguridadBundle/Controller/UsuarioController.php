<?php

namespace SeguridadBundle\Controller;

use SeguridadBundle\Entity\Usuario;
use SeguridadBundle\Form\UsuarioType;
use SeguridadBundle\Form\RecuperacionType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use AppBundle\Entity\Matricula_Temarios;
use AppBundle\Entity\Matricula_Secciones;
use AppBundle\Entity\Matricula_Servicios;

class UsuarioController extends Controller {
    
    private function emailConfirmacion($usuario, $mailer) {

        $message = (new \Swift_Message('[POE] - Confirmación de registro'))
            ->setFrom('send@example.com')
            ->setTo($usuario->getEmail())
            ->setBody(
                $this->renderView(
                    '@Seguridad/Emails/registro_realizado.html.twig', [
                        'usuario' => $usuario
                    ]
                ),
                'text/html'
            );

        $mailer->send($message);
    }

    private function emailRecuperacion($usuario, $mailer) {

        $message = (new \Swift_Message('[POE] - Recuperación de credenciales'))
            ->setFrom('send@example.com')
            ->setTo($usuario->getEmail())
            ->setBody(
                $this->renderView(
                    '@Seguridad/Emails/recuperacion_credenciales.html.twig', [
                        'usuario' => $usuario,
                    ]
                ),
                'text/html'
            );

        $mailer->send($message);
    }


    /**
     * @Route("/login", name="usuario_autentificar")
     */
    public function autentificarAction(Request $request, AuthenticationUtils $authenticationUtils) {
        
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();    
        $recordar = ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) ? true : false;
        
        return $this->render('@Seguridad/autentificar.html.twig', [
            'error' => $error,
            'recordar' => $recordar,
        ]);
    }

    /**
     * @Route("/registro", name="usuario_registrar")
     */
    public function registrarAction(Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer) {
        
        $usuario = new Usuario();

        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $usuario = $form->getData();
                $usuario->setIsActive(false);
                $usuario->setRol('ROLE_ALUMNO');

                // Codificando el password
                $encoded = $encoder->encodePassword($usuario, $usuario->getPassword());
                $usuario->setPassword($encoded);

                // Codificando el codigo
                $codigo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 15);
                $encoded = $encoder->encodePassword($usuario, $codigo);
                $usuario->setCodigo($encoded);                

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($usuario);
                $manager->flush();

                // volvemos a pasar a usuario el código sin codificar, para enviarlo por email
                $usuario->setCodigo($codigo);
                $this->emailConfirmacion($usuario, $mailer);

                return $this->render('@Seguridad/registro_realizado.html.twig', []);
            }
        }
        return $this->render('@Seguridad/registrar.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/activar/{username}/{codigo}", name="usuario_activar_registro", requirements={"token"=".+"})
     */
    public function activarAction(Request $request, $username, $codigo) {

        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $usuario = $repository->findOneByUsername($username);

        $activacion = false;
        if ($usuario->getCodigo() == $codigo) {
            $activacion = true;

            $usuario->setCodigo(null);
            $usuario->setIsActive(true);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($usuario);
            $manager->flush();
        }

        return $this->render('@Seguridad/activar.html.twig', [
            'activacion' => $activacion
        ]);
    }

    /**
     * @Route("/olvido", name="usuario_olvido")
     */
    public function olvidoAction(Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer) {
        
        // si hay request lo recoge, si no, email es false
        $request = Request::createFromGlobals();
        $email = $request->get('email', false);       

        if ($email) {
            $repository = $this->getDoctrine()->getRepository(Usuario::class);
            $usuario = $repository->findOneByEmail($email);        
            
            if ($usuario) {
                
                // Codificando el codigo
                $codigo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 15);
                $encoded = $encoder->encodePassword($usuario, $codigo);
                $usuario->setCodigo($encoded);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($usuario);
                $manager->flush();                

                // volvemos a pasar a usuario el código sin codificar, para enviarlo por email
                $usuario->setCodigo($codigo);
                $this->emailRecuperacion($usuario, $mailer);

            } else $email = false;
        }

        return $this->render('@Seguridad/olvido.html.twig', ['email' => $email]);
    }

    /**
     * @Route("/recuperar/{username}/{codigo}", name="usuario_recuperar")
     */
    public function recuperarAction(Request $request, UserPasswordEncoderInterface $encoder, $username, $codigo) {

        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $usuario = $repository->findOneByUsername($username);

        $recuperacion = false;

        if ($usuario && password_verify($codigo, $usuario->getCodigo())) {
            
            $recuperacion = true;

            // creamos el formulario para actualizar la clave
            $form = $this->createForm(RecuperacionType::class, $usuario);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // si el formulario se envía y además es válido:                

                $usuario = $form->getData();

                // Codificando el password
                $encoded = $encoder->encodePassword($usuario, $usuario->getPassword());
                $usuario->setPassword($encoded);

                $usuario->setCodigo(null);
                $usuario->setIsActive(true);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($usuario);
                $manager->flush();

                return $this->render('@Seguridad/recuperacion_realizada.html.twig', []);
            }

            return $this->render('@Seguridad/recuperar.html.twig', [
                'recuperacion' => $recuperacion,
                'usuario' => $usuario,
                'form' => $form->createView(),
            ]);

        }

        return $this->render('@Seguridad/recuperar.html.twig', [
            'recuperacion' => $recuperacion,
            'usuario' => $usuario,
        ]);
    }

    /**
     * @Route("/perfil/{username}", name="usuario_perfil")
     */
    public function perfilAction(Request $request, UserPasswordEncoderInterface $encoder, $username) {
        
        try {
            $user = $this->getUser();         
            if ($user->getUsername() != $username) throw new Exception("Acceso denegado", 1);

            $repository = $this->getDoctrine()->getRepository(Usuario::class);
            $usuario = $repository->findOneByUsername($username);

            // Buscando aquellos items en los que el usuario está matriculado, para mostrarlos en el perfil
            $em = $this->getDoctrine()->getManager();
            $matriculas_temarios = $em->getRepository(Matricula_Temarios::class)->findByUsuario($this->getUser()); 
            $matriculas_secciones = $em->getRepository(Matricula_Secciones::class)->findByUsuario($this->getUser()); 
            $matriculas_servicios = $em->getRepository(Matricula_Servicios::class)->findByUsuario($this->getUser()); 

            $form = $this->createForm(RecuperacionType::class, $usuario);
            $form->handleRequest($request);

            $actualizado = false;

            if ($form->isSubmitted() && $form->isValid()) {
                $usuario = $form->getData();

                // Codificando el password
                $encoded = $encoder->encodePassword($usuario, $usuario->getPassword());
                $usuario->setPassword($encoded);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($usuario);
                $manager->flush();

                $actualizado = true;
            }

            return $this->render('@Seguridad/perfil.html.twig', [
                'actualizado' => $actualizado,
                'usuario' => $usuario,
                'form' => $form->createView(),
                'matriculas_temarios' => $matriculas_temarios,
                'matriculas_secciones' => $matriculas_secciones,
                'matriculas_servicios' => $matriculas_servicios,
            ]);

        } catch (Exception $e) {
            return $this->render('Contenido/acceso_denegado.html.twig', [
                'error' => $e->getMessage()
            ]);
        }
    }

}
