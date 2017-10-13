<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AcoesController extends Controller {

    /**
     * @Route("/cadastrarAcao")
     */
    public function cadastrarAcaoAction(Request $request) {
       
        return $this->render('cadastroAtividade.html.twig');
    }

}
