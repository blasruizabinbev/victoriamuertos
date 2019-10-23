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
            'title' => 'Xibalba es la ofrenda más grande de México | Cerveza Victoria',
            'description' => 'Descubre la ofrenda más grande de México con Cerveza Victoria. Ingresa a nuestro sitio y visita o participa presentando tu ofrenda aquí. Descubre más.',
            'shareImage' => null
        ];
        switch($request->getPathInfo()) {
            case '/upload-photo':
                $meta['title'] = 'Haz la ofrenda más reconocida de Xibalba | Cerveza Victoria';
                $meta['description'] = 'Participa en el altar de muertos de Xibalba, para que tu hagas una ofrenda a los que pasaron a otra vida pero que siempre nos acompañan. Cerveza Victoria.';
                break;
            case '/ofrenda':
                $meta['title'] = 'Una ofrenda dedicada para los que no están | Cerveza Victoria';
                $meta['description'] = 'Visita la ofrenda Xibalba, un lugar dedicado para los que ya no están aquí, hecho por los que aún estamos en la tierra. Cerveza Victoria, más que cerveza.';
                break;
        }

        if($request->query->get('uuid') || $request->query->get('UUID')) {
            $uuid = $request->query->get('uuid') ?: $request->query->get('UUID');
            /** @var Profile $profile */
            $profile = $this->getDoctrine()->getRepository(Profile::class)->find($uuid);
            if($profile) {
                $meta['shareImage'] = $profile->getImage();
            }
        }
        return $this->render('base.html.twig', [
            'meta' => $meta
        ]);
    }

}