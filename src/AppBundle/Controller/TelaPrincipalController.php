<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
    /**
     * @Route("/home")
     */
    public function home(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('base.html.twig');
    }

}
