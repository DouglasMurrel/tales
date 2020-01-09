<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Mobile_Detect;

class MainPageController extends AbstractController
{
     /**
      * @Route("/")
      */
     public function index(){
         return $this->render('index.html.twig');
     }

    /**
     * @Route("/game/{game_id}", name="game_page")
     */
     public function game(string $game_id){
         return $this->render('game.html.twig',["game_id"=>$game_id]);
     }
}