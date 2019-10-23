<?php

namespace App\Controller\Admin;

use App\Entity\Profile;
use App\Service\MailService\MailService;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ModeratorController extends Controller
{

    /**
     * @var MailService
     */
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function listAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $result = $this->getDoctrine()
            ->getManager()
            ->createQuery("SELECT p FROM App:Profile p WHERE p.modStatus = 'pending' AND p.image IS NOT NULL AND p.image != '' ORDER BY p.createdAt ASC")
            ->setMaxResults(15)
            ->getResult();

        return $this->renderWithExtraParams('admin/moderator/list.html.twig', [
            'profiles' => $result
        ]);
    }

    public function storeAction(Request $request)
    {
        $requestData = $request->request->all();
        $approved    = $unapproved = [];
        foreach ($requestData['list'] as $imageId => $val) {
            if (array_key_exists('image', $requestData) && array_key_exists($imageId, $requestData['image'])) {
                $approved[] = $imageId;
            } else {
                $unapproved[] = $imageId;
            }
        }
        $approvedEntities = $this->getDoctrine()->getRepository(Profile::class)->findBy(['uuid' => $approved]);
        foreach ($approvedEntities as $entity) {
            /** @var Profile $entity */
            $entity->setModStatus(Profile::MOD_APPROVED);
        }
        $unapprovedEntities = $this->getDoctrine()->getRepository(Profile::class)->findBy(['uuid' => $unapproved]);
        foreach ($unapprovedEntities as $entity) {
            /** @var Profile $entity */
            $entity->setModStatus(Profile::MOD_DENIED);
        }
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('moderator_list');
    }
}