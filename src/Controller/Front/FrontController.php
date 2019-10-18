<?php

namespace App\Controller\Front;

use App\Entity\Profile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends AbstractController
{

    public function index(Request $request)
    {
        $meta = [
            'title' => 'Xibalba te lleva al inframundo con Victoria | Cerveza Victoria',
            'description' => 'Ingresa ahora y descubre cómo viajar al inframundo de Xibalba con Cerveza Victoria. Una experiencia que jamás olvidarás. Bienvenido, ¡descubre más aquí!',
            'shareImage' => null
        ];
        if($request->getRequestUri() === '/register') {
            $meta['title'] = 'Xibalba chingones hasta en la muerte | Cerveza Victoria';
            $meta['description'] = 'Xibalba quiere saber si eres chingón hasta en la muerte. Regístrate en nuestro sitio de Cerveza Victoria y participa por un viaje a la Rivera Maya.';
        }
        if($request->query->get('uuid') || $request->query->get('UUID')) {
            $uuid = $request->query->get('uuid') ?: $request->query->get('UUID');
            /** @var Profile $profile */
            $profile = $this->getDoctrine()->getRepository(Profile::class)->find($uuid);
            $meta['shareImage'] = $profile->getImage();
        }
        return $this->render('base.html.twig', [
            'meta' => $meta
        ]);
    }

}