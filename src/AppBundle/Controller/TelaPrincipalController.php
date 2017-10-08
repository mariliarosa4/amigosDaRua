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

public function home( )
{
    // or, you can also fetch the mailer service this way
    // $this->get('mailer')->send($message);
      
// replace this example code with whatever you need
        return $this->render('base.html.twig');
    }

}
