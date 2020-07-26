<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WelcomeController extends Controller
{
    /**
     * @Route("/", name="AppBundle_Welcome_homepage")
     *
     * Akcija za prikaz naslovne stranice
     * @return Response
     */
    public function homepageAction(Request $request)
    {
      return $this->render('AppBundle:Welcome:homepage.html.twig');
    }


    /**
     * @Route("/contact", name="AppBundle_Welcome_contact")
     *
     * Akcija za prikaz kontaktne stranice
     * @return Response
     */
    public function contactAction()
    {
      return $this->render('AppBundle:Welcome:contact.html.twig');
    }
}
