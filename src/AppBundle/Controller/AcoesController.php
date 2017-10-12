<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AcoesController extends Controller
{
    /**
     * @Route("/cadastrarAcao")
     */
    public function cadastrarAcaoAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('cadastroAtividade.html.twig');
    }
}
