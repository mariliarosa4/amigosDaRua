<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Acoes;
use AppBundle\Entity\Grupos;
use AppBundle\Entity\Locaisacoes;
use AppBundle\Entity\Categoriasdoacoes;
use AppBundle\Entity\Doacoesacoes;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Usuarios;
use SendGrid;

class CadastroGruposController extends Controller {

    public $logControle;
    public $em;

    public function __construct() {
        $this->logControle = new LogController();
    }

    /**
     * @Route("/validarEmail")
     */
    public function validarEmailAction(Request $request) {
        $this->em = $this->getDoctrine()->getManager();
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());

            $this->logControle->log("validar email existente: " . print_r($data, true));
            $verificarEmailExistente = $this->getDoctrine()
                    ->getRepository('AppBundle:Usuarios')
                    ->findBy(array('emailusuario' => $data['emailCadastro']));
            if ($verificarEmailExistente) {

                $retornoRequest = array(
                    "existe" => true
                );
            } else {
                $retornoRequest = array(
                    "existe" => false
                );
            }
        }
        $this->logControle->log("retorno request : " . print_r($retornoRequest, true));
        return new JsonResponse($retornoRequest);
    }

    /**
     * @Route("/cadastrarGrupo")
     */
    public function cadastrarGrupoAction(Request $request) {
        $this->em = $this->getDoctrine()->getManager();
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());

            $this->logControle->log("cadastrarGrupo: " . print_r($data, true));
            try {
                $objetoUsuario = new Usuarios();
                $objetoUsuario->setNmusuario($data['nomeResponsavel']);
                $objetoUsuario->setEmailusuario($data['emailResponsavel']);
                $objetoUsuario->setTpusuario('G');
                $dataNascimentoFormatada = new \DateTime($data['dataNascimentoResponsavel']);
                $objetoUsuario->setDtnascimento($dataNascimentoFormatada);


                $idUsuarioNovo = $objetoUsuario->getIdusuario();


                $objetoGrupo = new Grupos();
                $objetoGrupo->setNomegrupo($data['nomeGrupo']);
                $objetoGrupo->setTelefoneresponsavel($data['telefoneResponsavel']);
                if (!empty($data['numeroIntegrantes'])) {
                    $objetoGrupo->setNumerointegrantes($data['numeroIntegrantes']);
                }
                $objetoGrupo->setIdusuario($objetoUsuario);
                $this->em->persist($objetoUsuario);
                $this->em->persist($objetoGrupo);

                $codigo = $this->gerarCodigoAcesso($dataNascimentoFormatada, $data['nomeGrupo']);
                $objetoUsuario->setCodigoprimeiroacesso($codigo);
                $this->enviarEmailCodigo($codigo, $data['emailResponsavel'], $data['nomeResponsavel']);
                $this->em->persist($objetoUsuario);
                $this->em->flush();
                $retornoRequest = array(
                    "sucesso" => true
                );
            } catch (\Exception $e) {
                $this->logControle->log($e->getMessage() . " - " . $e->getCode());

                $retornoRequest = array(
                    "sucesso" => false
                );
            }
        } else {
            $retornoRequest = array(
                "sucesso" => false
            );
        }
        $this->logControle->log("retorno request : " . print_r($retornoRequest, true));
        return new JsonResponse($retornoRequest);
    }

    public function gerarCodigoAcesso($dtNascimento, $nomeGrupo) {
        $this->logControle->log("dt : " . print_r($dtNascimento, true));
        $hashCodigo = substr(md5($dtNascimento->date.$nomeGrupo), 0, 8);
        return $hashCodigo;
    }

    public function enviarEmailCodigo($hashCodigo, $email, $nome) {

        $from = new SendGrid\Email("appamigosdarua", "appamigosdarua@gmail.com");
        $subject = "primeiro acesso amigos da rua";
        $to = new SendGrid\Email(null, $email);
        $content = new SendGrid\Content("text/html", $this->renderView(
                        'Emails/emailCodigoAcesso.html.twig', array('hashCodigo' => $hashCodigo, "nome" => $nome, "email" => $email)
        ));
        $mail = new SendGrid\Mail($from, $subject, $to, $content);
        $apiKey = $this->container->getParameter('key_sendgrid');
        $sg = new \SendGrid($apiKey);
        $response = $sg->client->mail()->send()->post($mail);
        $this->logControle->log("codigo status response envio email: " . $response->statusCode());
    }

}
