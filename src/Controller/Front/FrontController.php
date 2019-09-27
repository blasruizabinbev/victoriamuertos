<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends AbstractController
{

    public function index(Request $request)
    {
        return $this->render('base.html.twig');
    }

}