<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

/**
 * Description of LoginController
 *
 * @author Marilia
 */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Usuarios;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LoginController extends Controller {

    public $formUserLogin;
    public $error = null;

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request) {
        if ($this->get('session')->get('idUser')) {

            return $this->redirectToRoute('home');
        } else {

            $user = new Usuarios();

            $this->formUserLogin = $this->createFormBuilder($user)
                    ->add('emailusuario', TextType::class, array('label' => false))
                    ->add('senhausuario', PasswordType::class, array('label' => false))
                    ->getForm();

            $this->formUserLogin->handleRequest($request);
        }
        if ($this->formUserLogin->isSubmitted() && $this->formUserLogin->isValid()) {
            if ($this->autenticacao($user->getEmailusuario(), $user->getSenhausuario())) {
                return $this->redirectToRoute('home');
            } else {
                return $this->render('login.html.twig', array(
                            'form' => $this->formUserLogin->createView(), 'erro' => $this->error
                ));
            }
        }
        return $this->render('login.html.twig', array(
                    'form' => $this->formUserLogin->createView(), 'erro' => $this->error
        ));
    }

    public function autenticacao($email, $senha) {

        // $senha = hash('sha256', $senha);
        $usuarioAutenticado = $this->getDoctrine()
                ->getRepository('AppBundle:Usuarios')
                ->findBy(array('emailusuario' => $email, 'senhausuario' => $senha));


        if (!$usuarioAutenticado) {
            $this->error = "Usuário ou senha inválidos!";
            return false;
        } else {

            $idUser = $usuarioAutenticado[0]->getIdusuario();
            $this->get('session')->set('idUser', $idUser);

            return true;
        }
    }

    /**
     * @Route("/logout")
     */
    public function logoutAction() {

        $this->get('session')->invalidate();
        return $this->redirectToRoute('login');
    }
     /**
     * @Route("/esqueceuSenha")
     */
public function esqueceuSenha(){
    $dtNascimento = "04/12/1996";
    $email = "mariliarosilva@gmail.com";
    $nome = "marilia";
           
    $this->enviarEmailEsquecerSenha($dtNascimento, $email, $nome);
       return $this->render('base.html.twig');
}
    public function enviarEmailEsquecerSenha($dtNascimento, $email,$nome) {
      $criptografia= hash('sha256',$dtNascimento.'amigosapp'.$email);
    
        $message = (new \Swift_Message('Redefinir senha'))
                ->setFrom('appamigosdarua@gmail.com')
                ->setTo('mariliarosilva@gmail.com')
                ->setBody(
                $this->renderView(
                        'Emails/email.html.twig', array('criptografia' => $criptografia, "nome"=>$nome, "email"=>$email)
                ), 'text/html'
                )

        ;

        $this->get('mailer')->send($message);
    }

}
