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

class AcoesController extends Controller {

    public $logControle;
    public $em;

    public function __construct() {
        $this->logControle = new LogController();
    }

    /**
     * @Route("/cadastrarAcao")
     */
    public function cadastrarAcaoAction(Request $request) {
        $this->em = $this->getDoctrine()->getManager();


        $opcosDoacoes = $this->carregarCategoriasDoacoes();
        return $this->render('cadastroAcao.html.twig', array('opcoesDoacoes' => $opcosDoacoes));
    }

    function carregarCategoriasDoacoes() {
        $opcosDoacoes = array();
        $objetoCategoriasDoacoes = $this->em->getRepository('AppBundle:Categoriasdoacoes')
                ->findAll();
        foreach ($objetoCategoriasDoacoes as $objeto) {
            $opcosDoacoes[] = array(
                'subcategoria' => $objeto->getNomesubcategoria(),
                'categoria' => $objeto->getNomecategoria(),
                'idCategoria' => $objeto->getIdcategoriasdoacoes()
            );
        }
        return $opcosDoacoes;
    }

    /**
     * @Route("/acao/{codigo}")
     */
    public function acaoAction($codigo) {
        $this->em = $this->getDoctrine()->getManager();


        $queryBuilderAcao = $this->em->createQueryBuilder();
        $queryBuilderAcao
                ->select('a,g')
                ->from('AppBundle:Acoes', 'a')
                ->innerJoin('a.idgrupos', 'g', 'WITH', 'a.idgrupos= g.idgrupos')
                ->where($queryBuilderAcao->expr()->eq('a.idgrupos', $this->get('session')->get('idGrupo')))
                ->andWhere($queryBuilderAcao->expr()->eq('a.idacao', $codigo))
                ->getQuery()
                ->execute();
        $resultadoAcao = $queryBuilderAcao->getQuery()->getArrayResult();

        foreach ($resultadoAcao as $acao) {

            $dadosAcao['acao'] = array(
                'data' => $acao['dtacao']->format('Y-m-d'),
                'hora' => $acao['horaacao']->format('H:i:s'),
                'descricao' => $acao['dsacao']
            );
        }
        $queryBuilderAcaoLocal = $this->em->createQueryBuilder();
        $queryBuilderAcaoLocal
                ->select('l')
                ->from('AppBundle:Locaisacoes', 'l')
                ->innerJoin('l.idacao', 'a', 'WITH', 'a.idacao= l.idacao')
                ->where($queryBuilderAcaoLocal->expr()->eq('l.idacao', $codigo))
                ->getQuery()
                ->execute();
        $resultadoAcaoLocal = $queryBuilderAcaoLocal->getQuery()->getArrayResult();
        foreach ($resultadoAcaoLocal as $acaoLocal) {

            $dadosAcao['endereco'] = array(
                'endereco' => $acaoLocal['endereco']
            );
        }


        $queryBuilderAcaoDoacoes = $this->em->createQueryBuilder();
        $queryBuilderAcaoDoacoes
                ->select('ca,do,a')
                ->from('AppBundle:Doacoesacoes', 'do')
                ->innerJoin('do.idacao', 'a', 'WITH', 'a.idacao= do.idacao')
                ->innerJoin('do.idcategoriasdoacao', 'ca', 'WITH', 'do.idcategoriasdoacao= ca.idcategoriasdoacoes')
                ->where($queryBuilderAcaoDoacoes->expr()->eq('do.idacao', $codigo))
                ->getQuery()
                ->execute();
        $resultadoAcaoDoacoes = $queryBuilderAcaoDoacoes->getQuery()->getArrayResult();
        foreach ($resultadoAcaoDoacoes as $acoesDoacoes) {

            $dadosAcao['categoriasChecked'][$acoesDoacoes['idcategoriasdoacao']['idcategoriasdoacoes']] = true;
        }
        $opcosDoacoes = $this->carregarCategoriasDoacoes();
        $this->logControle->log("dados acao : " . print_r($dadosAcao, true));
        return $this->render('cadastroAcao.html.twig', array('opcoesDoacoes' => $opcosDoacoes, 'acaoEdicao' => $dadosAcao, 'idAcao' => $codigo));
    }

    /**
     * @Route("/salvarAcao")
     */
    public function salvarAcao(Request $request) {
        $this->em = $this->getDoctrine()->getManager();
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
            $this->logControle->log("salvarAcao : " . print_r($data, true));
            if (!empty($data['idAcao'])) {
                $acao = $this->getDoctrine()
                        ->getRepository('AppBundle:Acoes')
                        ->findOneBy(array('idacao' => $data['idAcao']));
            } else {
                $acao = new Acoes();
            }
            if (!empty($data['detalhes'])) {
                $acao->setDsacao($data['detalhes']);
            }
            $dataFormatada = new \DateTime($data['data']);

            $acao->setDtacao($dataFormatada);

            $horaFormatada = new \DateTime($data['hora']);
            $acao->setHoraacao($horaFormatada);

            $objetoGrupo = $this->getDoctrine()
                    ->getRepository('AppBundle:Grupos')
                    ->findBy(array('idgrupos' => $this->get('session')->get('idGrupo')));
            $acao->setIdgrupos($objetoGrupo[0]);
            $this->em->persist($acao);
            $this->em->flush();
            $this->em = $this->getDoctrine()->getManager();
            
            
            $localAcao = new Locaisacoes();
            $localAcao->setEndereco($data['local']);
            $localAcao->setIdacao($acao);
            $this->em->persist($localAcao);
            $this->em->flush();
            
            $this->em = $this->getDoctrine()->getManager();
            foreach ($data['categorias'] as $categorias) {
                $this->logControle->log("categorias : " . print_r($categorias, true));

                $objetoCategoriaDoacao = $this->getDoctrine()
                        ->getRepository('AppBundle:Categoriasdoacoes')
                        ->findBy(array('idcategoriasdoacoes' => $categorias));
                if ($objetoCategoriaDoacao) {
                    $doacaoAcao = new Doacoesacoes();
                    $doacaoAcao->setIdacao($acao);
                    $doacaoAcao->setIdcategoriasdoacao($objetoCategoriaDoacao[0]);
                    $this->em->persist($doacaoAcao);
                }
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
        $this->logControle->log("retorno request : " . print_r($retornoRequest, true));
        return new JsonResponse($retornoRequest);
    }
    /**
     * @Route("/minhasAcoes")
     */
    public function selecionarAcoesAction() {
        $this->em = $this->getDoctrine()->getManager();


        $queryBuilderAcao = $this->em->createQueryBuilder();
        $queryBuilderAcao
                ->select('a,g')
                ->from('AppBundle:Acoes', 'a')
                ->innerJoin('a.idgrupos', 'g', 'WITH', 'a.idgrupos= g.idgrupos')
               ->where($queryBuilderAcao->expr()->eq('a.idgrupos', $this->get('session')->get('idGrupo')))
                ->orderBy('a.dtacao', 'ASC')
                ->orderBy('a.horaacao', 'ASC')
                ->getQuery()
                ->execute();
        $resultadoAcao = $queryBuilderAcao->getQuery()->getArrayResult();
        $dadosAcao = array();
        foreach ($resultadoAcao as $acao) {
            $this->logControle->log("acoes : " . print_r($acao, true));
            $dadosAcao[$acao['idacao']]['acao'] = array(
                'data' => $acao['dtacao']->format('d-m-Y'),
                'hora' => $acao['horaacao']->format('H:i'),
                'descricao' => $acao['dsacao'],
                'nomeGrupo' => $acao['idgrupos']['nomegrupo']
            );

            $queryBuilderAcaoLocal = $this->em->createQueryBuilder();
            $queryBuilderAcaoLocal
                    ->select('l')
                    ->from('AppBundle:Locaisacoes', 'l')
                    ->innerJoin('l.idacao', 'a', 'WITH', 'a.idacao= l.idacao')
                    ->where($queryBuilderAcaoLocal->expr()->eq('l.idacao', $acao['idacao']))
                    ->getQuery()
                    ->execute();
            $resultadoAcaoLocal = $queryBuilderAcaoLocal->getQuery()->getArrayResult();
            foreach ($resultadoAcaoLocal as $acaoLocal) {

                $dadosAcao[$acao['idacao']]['endereco'][] = array(
                    'endereco' => $acaoLocal['endereco']
                );
            }


            $queryBuilderAcaoDoacoes = $this->em->createQueryBuilder();
            $queryBuilderAcaoDoacoes
                    ->select('ca,do,a')
                    ->from('AppBundle:Doacoesacoes', 'do')
                    ->innerJoin('do.idacao', 'a', 'WITH', 'a.idacao= do.idacao')
                    ->innerJoin('do.idcategoriasdoacao', 'ca', 'WITH', 'do.idcategoriasdoacao= ca.idcategoriasdoacoes')
                    ->where($queryBuilderAcaoDoacoes->expr()->eq('do.idacao', $acao['idacao']))
                    ->getQuery()
                    ->execute();
            $resultadoAcaoDoacoes = $queryBuilderAcaoDoacoes->getQuery()->getArrayResult();
            foreach ($resultadoAcaoDoacoes as $acoesDoacoes) {

                $dadosAcao[$acao['idacao']]['categoriasChecked'][$acoesDoacoes['idcategoriasdoacao']['idcategoriasdoacoes']] = $acoesDoacoes['idcategoriasdoacao']['nomesubcategoria'];
            }
        }
        $this->logControle->log("acoes do grupo : " . print_r($dadosAcao, true));
        return $this->render('home.html.twig', array('acoes' => $dadosAcao));
    }
}
