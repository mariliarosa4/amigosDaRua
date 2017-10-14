<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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


        $objetoCategoriasDoacoes = $this->em->getRepository('AppBundle:Categoriasdoacoes')
                ->findAll();
        foreach ($objetoCategoriasDoacoes as $objeto) {
            $opcosDoacoes[] = array(
                'subcategoria' => $objeto->getNomesubcategoria(),
                'categoria' => $objeto->getNomecategoria(),
                'idCategoria' => $objeto->getIdcategoriasdoacoes()
            );
        }
        return $this->render('cadastroAcao.html.twig', array('opcoesDoacoes' => $opcosDoacoes));
    }

}
