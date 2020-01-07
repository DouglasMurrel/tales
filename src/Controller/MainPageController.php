<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainPageController extends AbstractController
{
     /**
      * @Route("/")
      */
     public function index(){
         return $this->render('MainPage.html.twig');
     }
}