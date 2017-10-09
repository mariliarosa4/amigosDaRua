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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;

class LoginController extends Controller {

    public $formUserLogin;
    public $error = null;
    public $codigo = 'amigosapp';
    public $logControle;
    public $em;

    public function __construct() {
        $this->logControle = new LogController();
    }

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
    public function esqueceuSenha(Request $request) {
        $this->em = $this->getDoctrine()->getManager();
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());

            $this->logControle->log("email : " . print_r($data, true));

            $this->em = $this->getDoctrine()->resetManager();
            $this->logControle->log("desativar  : " . print_r($data['email'], true));

            $objetoUsuario = $this->em->getRepository('AppBundle:Usuarios')
                    ->findOneBy(array('emailusuario' => $data['email']));
            $this->logControle->log(print_r($objetoUsuario, true));
            if ($objetoUsuario != null) {
                $nome = $objetoUsuario->getNmusuario();
                $email = $objetoUsuario->getEmailusuario();
                $dataNascimento = $objetoUsuario->getDtnascimento()->format('Y-m-d');
                $this->enviarEmailEsquecerSenha($dataNascimento, $email, $nome);
            }

            $retornoRequest = array(
                "sucesso" => true
            );
        } else {
            $retornoRequest = array(
                "sucesso" => false
            );
        }
        return new JsonResponse($retornoRequest);
    }

    public function enviarEmailEsquecerSenha($dtNascimento, $email, $nome) {
        $criptografia = base64_encode($dtNascimento . '/' . $this->codigo . '/' . $email);


        $message = (new \Swift_Message('Redefinir senha'))
                ->setFrom('appamigosdarua@gmail.com')
                ->setTo('mariliarosilva@gmail.com')
                ->setBody(
                $this->renderView(
                        'Emails/email.html.twig', array('criptografia' => $criptografia, "nome" => $nome, "email" => $email)
                ), 'text/html'
        );

        $this->get('mailer')->send($message);
    }

    /**
     * @Route("/change/{email}/{criptografia}")
     */
    public function alterarSenha($email, $criptografia) {
        $stringDescriptografada = base64_decode($criptografia);
        $arrayString = (explode("/", $stringDescriptografada));
        $this->logControle->log(print_r($arrayString, true));
        $dtNascimento = $arrayString[0];
        $codigo = $arrayString[1];
        $emailString = $arrayString[2];
        $this->logControle->log("Dtnascimento: " . $dtNascimento . " " . "emailstring " . $email);
        $dataTime = new \DateTime($dtNascimento);

        if ($email == $emailString && $codigo == $this->codigo) {

            $validarUusario = $this->getDoctrine()
                    ->getRepository('AppBundle:Usuarios')
                    ->findBy(array('emailusuario' => $email));
            if (!$validarUusario) {
                $this->logControle->log("invalido");
                return $this->redirectToRoute('login'); //verificar outra possibilidade de mostrar erro
            } else {
                if ($validarUusario[0]->getDtnascimento()->format('Y-m-d') == $dtNascimento) {
                    $this->logControle->log("valido");
                    return $this->render('base.html.twig'); //pagina para inserir nova senha
                } else {
                    $this->logControle->log("invalido");
                    return $this->redirectToRoute('login');
                }
            }
        }
    }

    /**
     * @Route("/novaSenha")
     */
    public function novaSenha(Request $request) {
        $this->em = $this->getDoctrine()->getManager();
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());

            $this->logControle->log("nova senha : " . print_r($data, true));

            $this->em = $this->getDoctrine()->resetManager();

            $objetoUsuario = $this->em->getRepository('AppBundle:Usuarios')
                    ->findOneBy(array('emailusuario' => $data['email']));
            $this->logControle->log(print_r($objetoUsuario, true));
            if ($objetoUsuario != null) {
                $objetoUsuario->getSenhausuario($data['novasenha']);
                $this->em->flush();
            }

            $retornoRequest = array(
                "sucesso" => true
            );
        } else {
            $retornoRequest = array(
                "sucesso" => false
            );
        }
        return new JsonResponse($retornoRequest);
        // return $this->redirectToRoute('login');
    }

    /**
     * @Route("/primeiroacesso")
     */
    public function primeiroacesso(Request $request) {
        $this->em = $this->getDoctrine()->getManager();
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());

            $this->logControle->log("primeiro acesso: " . print_r($data, true));

            $this->em = $this->getDoctrine()->resetManager();

            $queryBuilderPrimeiro = $this->em->createQueryBuilder();
            $queryBuilderPrimeiro
                    ->select('u,g')
                    ->from('AppBundle:Grupos', 'g')
                    ->innerJoin('g.idusuario', 'u', 'WITH', 'u.idusuario= g.idusuario')
                    ->where($queryBuilderPrimeiro->expr()->eq('u.emailusuario', "'" . $data['email'] . "'"))
                    ->andWhere($queryBuilderPrimeiro->expr()->eq('g.codigoprimeiroacesso', "'" . $data['codigo'] . "'"))
                    ->andWhere($queryBuilderPrimeiro->expr()->eq('u.tpusuario', "'G'"))
                    ->getQuery()
                    ->execute();
            $dadosPrimeiroAcesso = $queryBuilderPrimeiro->getQuery()->getArrayResult();

            $this->logControle->log(print_r($dadosPrimeiroAcesso, true));
            if (count($dadosPrimeiroAcesso) > 0) {
                $objetoGrupo = $this->em->getRepository('AppBundle:Grupos')
                        ->findOneBy(array('idgrupos' => $dadosPrimeiroAcesso[0]['idgrupos']));
                $this->logControle->log(print_r($objetoGrupo, true));
                if ($objetoGrupo != null) {
                    $date = new \DateTime();
                   
                    $objetoGrupo->setDataprimeiroacesso($date);
                    $this->em->flush();
                }

                $retornoRequest = array(
                    "sucesso" => true
                );
                // return $this->redirectToRoute('editarPerfil');
            } else {
                $retornoRequest = array(
                    "sucesso" => false
                );
                //tratar para codigo incorreto
            }
        }
        return new JsonResponse($retornoRequest);
    }

    /**
     * @Route("/logout")
     */
    public function logout() {

        $this->get('session')->invalidate();
        return $this->redirectToRoute('login');
    }

}