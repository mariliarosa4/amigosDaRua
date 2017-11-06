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
use SendGrid;

class LoginController extends Controller {

    public $formUserLogin;
    public $formAlterarSenha;
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
                $this->em = $this->getDoctrine()->getManager();

                $queryBuilderGrupo = $this->em->createQueryBuilder();
                $queryBuilderGrupo
                        ->select('u,g')
                        ->from('AppBundle:Grupos', 'g')
                        ->innerJoin('g.idusuario', 'u', 'WITH', 'u.idusuario= g.idusuario')
                        ->where($queryBuilderGrupo->expr()->eq('u.emailusuario', "'" . $user->getEmailusuario() . "'"))
                        ->andWhere($queryBuilderGrupo->expr()->eq('u.tpusuario', "'G'"))
                        ->getQuery()
                        ->execute();
                $queryBuilderGrupo = $queryBuilderGrupo->getQuery()->getArrayResult();

                $this->logControle->log("grupoAutenticado : " . print_r($queryBuilderGrupo, true));
                if ($queryBuilderGrupo[0]['idusuario']['tpusuario'] == 'G') {
                    $this->get('session')->set('idGrupo', $queryBuilderGrupo[0]['idgrupos']);
                     return $this->redirectToRoute('home');
                } else {
                   
                        $this->get('session')->set('admin', $queryBuilderGrupo[0]['idusuario']['idusuario']);
                        return $this->redirectToRoute('admin');
                   
                       
                }
               
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

    public function autenticacao($email, $senha2) {

        $senha = hash('sha256', $senha2);
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



            $this->em = $this->getDoctrine()->resetManager();


            $objetoUsuario = $this->em->getRepository('AppBundle:Usuarios')
                    ->findOneBy(array('emailusuario' => $data['email']));
            $this->logControle->log(print_r($objetoUsuario, true));
            if ($objetoUsuario != null) {
                $nome = $objetoUsuario->getNmusuario();
                $email = $objetoUsuario->getEmailusuario();
                $dataNascimento = $objetoUsuario->getDtnascimento()->format('Y-m-d');
                $this->enviarEmailEsquecerSenha($dataNascimento, $email, $nome);

                $retornoRequest = array(
                    "sucesso" => true
                );
            } else {
                $retornoRequest = array(
                    "emailNaoCadastrado" => true
                );
            }
        } else {
            $retornoRequest = array(
                "sucesso" => false
            );
        }
        return new JsonResponse($retornoRequest);
    }

    public function enviarEmailEsquecerSenha($dtNascimento, $email, $nome) {
        $dataAtual = new \DateTime();

        $dataAtualFormatada = $dataAtual->format('Y-m-d');
        $criptografia = base64_encode($dtNascimento . '/' . $this->codigo . '/' . $email . '/' . $dataAtualFormatada);


        $from = new SendGrid\Email("appamigosdarua", "appamigosdarua@gmail.com");
        $subject = "Redefinir senha";
        $to = new SendGrid\Email(null, $email);
        $content = new SendGrid\Content("text/html", $this->renderView(
                        'Emails/email.html.twig', array('criptografia' => $criptografia, "nome" => $nome, "email" => $email)
        ));
        $mail = new SendGrid\Mail($from, $subject, $to, $content);
        $apiKey = $this->container->getParameter('key_sendgrid');
        $sg = new \SendGrid($apiKey);
        $response = $sg->client->mail()->send()->post($mail);
        $this->logControle->log("codigo status response envio email: " . $response->statusCode());
    }

    /**
     * @Route("/change/{criptografia}")
     */
    public function alterarSenha($criptografia, Request $request) {
        $stringDescriptografada = base64_decode($criptografia);
        $arrayString = (explode("/", $stringDescriptografada));
        $this->logControle->log(print_r($arrayString, true));
        $dtNascimento = $arrayString[0];
        $codigo = $arrayString[1];
        $emailString = $arrayString[2];
        $dataCodigo = $arrayString[3];

        $dataAtual = new \DateTime();
        $dataCodigoFormatada = new \DateTime($dataCodigo);

        $intervalo = $dataAtual->diff($dataCodigoFormatada);
        $this->logControle->log("diferenca: " . print_r($intervalo, true));
        if ($intervalo->days <= 3) {

            $dataTime = new \DateTime($dtNascimento);

            if ($codigo == $this->codigo) {

                $validarUusario = $this->getDoctrine()
                        ->getRepository('AppBundle:Usuarios')
                        ->findBy(array('emailusuario' => $emailString));
                if (!$validarUusario) {
                    $this->logControle->log("invalido");
                    return $this->redirectToRoute('login'); //verificar outra possibilidade de mostrar erro
                } else {
                    if ($validarUusario[0]->getDtnascimento()->format('Y-m-d') == $dtNascimento) {
                        $this->logControle->log("valido");

                        return $this->render('definirSenha.html.twig', array('email' => $emailString));
                    } else {
                        $this->logControle->log("invalido");
                        return $this->redirectToRoute('login');
                    }
                }
            }
        } else {
            return $this->render('login.html.twig');
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



            $objetoUsuario = $this->em->getRepository('AppBundle:Usuarios')
                    ->findOneBy(array('emailusuario' => $data['email']));
            $this->logControle->log(print_r($objetoUsuario, true));
            if ($objetoUsuario != null) {
                   $senha = hash('sha256', $data['confirmaSenha']);
                $objetoUsuario->setSenhausuario($senha);
                $this->em->persist($objetoUsuario);
                $this->em->flush();
            }

            $retornoRequest = array(
                "sucesso" => true
            );
            if ($this->get('session')->get('primeiroAcesso')) {
                $this->get('session')->invalidate();
            }
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

            $validarUusario = $this->getDoctrine()
                    ->getRepository('AppBundle:Usuarios')
                    ->findOneBy(array('emailusuario' => $data['email'], 'tpusuario' => 'G', 'codigoprimeiroacesso' => $data['codigo']));

            $this->logControle->log("validar: " . print_r($validarUusario, true));


            if (count($validarUusario) > 0) {

                $date = new \DateTime();

                $validarUusario->setDtprimeiroacesso($date);
                $this->em->persist($validarUusario);
                $this->em->flush();
                $this->get('session')->set('primeiroAcesso', $data['email']);
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
     * @Route("/registrarSenha")
     */
    public function registrarSenha(Request $request) {
        $emailPrimeiroAcesso = $this->get('session')->get('primeiroAcesso');
        return $this->render('definirSenha.html.twig', array('email' => $emailPrimeiroAcesso));
    }

    /**
     * @Route("/logout")
     */
    public function logout() {

        $this->get('session')->invalidate();
        return $this->redirectToRoute('login');
    }

}
