<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Grupos;
use Symfony\Component\HttpFoundation\JsonResponse;

class PerfilController extends Controller {

    public $logControle;
    public $em;

    public function __construct() {
        $this->logControle = new LogController();
    }

    /**
     * @Route("/perfil")
     */
    public function perfilAction() {
        $this->em = $this->getDoctrine()->getManager();


        $dadosPerfil = $this->carregaDados();
        return $this->render('editarPerfil.html.twig', array('dadosPerfil' => $dadosPerfil));
    }

    function carregaDados() {
        $dados = array();
        $queryBuilderGrupo = $this->em->createQueryBuilder();
        $queryBuilderGrupo
                ->select('u,g')
                ->from('AppBundle:Grupos', 'g')
                ->innerJoin('g.idusuario', 'u', 'WITH', 'u.idusuario= g.idusuario')
                ->where($queryBuilderGrupo->expr()->eq('g.idgrupos', "'" . $this->get('session')->get('idGrupo') . "'"))
                ->andWhere($queryBuilderGrupo->expr()->eq('u.tpusuario', "'G'"))
                ->getQuery()
                ->execute();
        $dadosGrupoUsuario = $queryBuilderGrupo->getQuery()->getArrayResult();
        $this->logControle->log("dados grupo usuario : " . print_r($dadosGrupoUsuario, true));

        $dados = array(
            'nmusuario' => $dadosGrupoUsuario[0]['idusuario']['nmusuario'],
            'dtnascimento' => $dadosGrupoUsuario[0]['idusuario']['dtnascimento']->format('Y-m-d'),
            'telefoneresponsavel' => $dadosGrupoUsuario[0]['telefoneresponsavel'],
            'numerointegrantes' => $dadosGrupoUsuario[0]['numerointegrantes'],
            'nomegrupo' => $dadosGrupoUsuario[0]['nomegrupo']
        );
        $this->logControle->log("array dados : " . print_r($dados, true));
        return $dados;
    }

    /**
     * @Route("/salvarEdicaoPerfil")
     */
    public function salvarEdicaoPerfilAction(Request $request) {
        $this->em = $this->getDoctrine()->getManager();
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());

            $this->logControle->log("salvar edicao perfil : " . print_r($data, true));
            try {

                $queryBuilderGrupo = $this->em->createQueryBuilder();
                $queryBuilderGrupo
                        ->select('u,g')
                        ->from('AppBundle:Grupos', 'g')
                        ->innerJoin('g.idusuario', 'u', 'WITH', 'u.idusuario= g.idusuario')
                        ->where($queryBuilderGrupo->expr()->eq('g.idgrupos', 22))
                        ->andWhere($queryBuilderGrupo->expr()->eq('u.tpusuario', "'G'"))
                        ->getQuery()
                        ->execute();
                $dadosGrupoUsuario = $queryBuilderGrupo->getQuery()->getResult();
                $this->logControle->log("salvar edicao perfil : " . print_r($dadosGrupoUsuario[0], true));

                $dataNascimentoFormatada = new \DateTime($data['dataNascimentoResponsavel']);
                $dadosGrupoUsuario[0]->getIdusuario()->setDtnascimento($dataNascimentoFormatada);
                $dadosGrupoUsuario[0]->getIdusuario()->setNmusuario($data['nomeResponsavel']);
                $dadosGrupoUsuario[0]->setTelefoneresponsavel($data['telefoneResponsavel']);
                $dadosGrupoUsuario[0]->setNomegrupo($data['nomeGrupo']);
                if (!empty($data['integrantesGrupo'])) {
                    $dadosGrupoUsuario[0]->setNumerointegrantes($data['integrantesGrupo']);
                }
                $this->em->persist($dadosGrupoUsuario[0]);
                $this->em->flush();
                $this->logControle->log("dados grupo usuario : " . print_r($dadosGrupoUsuario, true));

                $retornoRequest = array(
                    "sucesso" => true
                );
            } catch (\Exception $e) {
                $retornoRequest = array(
                    "sucesso" => false
                );
            }
        } else {
            $retornoRequest = array(
                "sucesso" => false
            );
        }
        return new JsonResponse($retornoRequest);
    }

    /**
     * @Route("/alterarSenha")
     */
    public function alterarSenhaAction(Request $request) {
        $this->em = $this->getDoctrine()->getManager();
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());

            $this->logControle->log("atualizar senha : " . print_r($data, true));
            try {

                $queryBuilderGrupo = $this->em->createQueryBuilder();
                $queryBuilderGrupo
                        ->select('u,g')
                        ->from('AppBundle:Grupos', 'g')
                        ->innerJoin('g.idusuario', 'u', 'WITH', 'u.idusuario= g.idusuario')
                        ->where($queryBuilderGrupo->expr()->eq('g.idgrupos', $this->get('session')->get('idGrupo')))
                        ->andWhere($queryBuilderGrupo->expr()->eq('u.tpusuario', "'G'"))
                        ->getQuery()
                        ->execute();
                $dadosGrupoUsuario = $queryBuilderGrupo->getQuery()->getResult();
                $this->logControle->log("dados : " . print_r($dadosGrupoUsuario[0], true));


                $senhaBanco = $dadosGrupoUsuario[0]->getIdusuario()->getSenhausuario();
                if ($senhaBanco == $data['S']) {

                    $senhaNova = hash('sha256', $data['CS']);
                    $senhaBanco = $dadosGrupoUsuario[0]->getIdusuario()->setSenhausuario($senhaNova);

                    $this->em->persist($dadosGrupoUsuario[0]);
                    $this->em->flush();
                    $this->logControle->log("dados grupo usuario : " . print_r($dadosGrupoUsuario, true));
                    $retornoRequest = array(
                        "sucesso" => true
                    );
                } else {
                    $retornoRequest = array(
                        "senhaAtualIncorreta" => true
                    );
                }
            } catch (\Exception $e) {
                $retornoRequest = array(
                    "sucesso" => false
                );
            }
        } else {
            $retornoRequest = array(
                "sucesso" => false
            );
        }
        return new JsonResponse($retornoRequest);
    }

}
