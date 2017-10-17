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

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of TelaPrincipal
 *
 * @author Marilia
 */
class TelaPrincipalController extends Controller {

    public $logControle;
    public $em;

    public function __construct() {
        $this->logControle = new LogController();
    }

    /**
     * @Route("/home")
     */
    public function home() {
        $this->em = $this->getDoctrine()->getManager();


        $queryBuilderAcao = $this->em->createQueryBuilder();
        $queryBuilderAcao
                ->select('a,g')
                ->from('AppBundle:Acoes', 'a')
                ->innerJoin('a.idgrupos', 'g', 'WITH', 'a.idgrupos= g.idgrupos')
                ->orderBy('a.dtacao', 'ASC')
                ->orderBy('a.horaacao', 'ASC')
                ->getQuery()
                ->execute();
        $resultadoAcao = $queryBuilderAcao->getQuery()->getArrayResult();

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
