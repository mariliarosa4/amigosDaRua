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

public function home( \Swift_Mailer $mailer)
{
  
    $message = (new \Swift_Message('Hello Email'))
        ->setFrom('mariliarosilva@gmail.com')
        ->setTo('appamigosdarua@gmail.com')
        ->setBody(
            $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                'Emails/email.html.twig',
                array('name' => "oi")
            ),
            'text/html'
        )
        
        
       
        
    ;

    $mailer->send($message);

    // or, you can also fetch the mailer service this way
    // $this->get('mailer')->send($message);
      
// replace this example code with whatever you need
        return $this->render('base.html.twig');
    }

}
