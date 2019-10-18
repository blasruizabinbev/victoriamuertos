<?php

namespace App\Transformer;

use App\Entity\Profile;
use League\Fractal\TransformerAbstract;

class ProfileTransformer extends TransformerAbstract
{

    protected $s3WebUrl;

    public function __construct($s3WebUrl)
    {
        $this->s3WebUrl = $s3WebUrl;
    }

    public function transform(Profile $entity)
    {
        return [
            'uuid' => $entity->getUuid(),
            'offerName' => $entity->getOfferName(),
            'offerVariation' => $entity->getOfferVariation(),
            'image' => $this->s3WebUrl . 'images/' . $entity->getImage()
        ];
    }

}