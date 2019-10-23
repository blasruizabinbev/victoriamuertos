<?php

namespace App\Repository;

use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ProfileRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }

    public function saveProfile(Profile $profile)
    {
        $this->_em->persist($profile);
        $this->_em->flush();
    }

    public function findWithOffer($offset, $limit)
    {
        $q = $this->_em->createQuery('SELECT p FROM App:Profile p WHERE p.offerVariation IS NOT NULL AND p.modStatus = \'approved\' ORDER BY p.createdAt DESC');
        $q->setFirstResult($offset);
        $q->setMaxResults($limit);
        return $q->getResult();
    }

    public function findMax()
    {
        $q = $this->_em->createQuery('SELECT COUNT(p) AS num FROM App:Profile p WHERE p.offerVariation IS NOT NULL AND p.modStatus = \'approved\'');
        return intval($q->getSingleScalarResult());
    }
}