<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * DefaultController
 * 
 */
class DefaultController extends Controller
{   
    /**
     * @Route("/", name="home_index")
     * @Template(":Frontend/Default:index.html.twig")
     */
    public function indexAction()
    {
        return array('msg' => 'Bienvenue sur la page d\'index du Player Manager');
    }
}
