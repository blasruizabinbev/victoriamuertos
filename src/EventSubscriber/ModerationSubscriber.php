<?php

namespace App\EventSubscriber;

use App\Entity\Profile;
use App\Event\ProfileModerated;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use MediaMonks\Doctrine\Transformable\Transformer\DefuseCryptoEncryptKeyTransformer;
use MediaMonks\Doctrine\Transformable\Transformer\TransformerPool;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ModerationSubscriber implements EventSubscriber
{

    /** @var EventDispatcherInterface */
    protected $dispatcher;

    /** @var DefuseCryptoEncryptKeyTransformer */
    protected $encrypt;

    public function __construct(EventDispatcherInterface $dispatcher, TransformerPool $transformerPool)
    {
        $this->dispatcher = $dispatcher;
        $this->encrypt = $transformerPool->get('encrypt');
    }

    /**
     * Doctrine has no event priorities so we'll have to reverse transform the encrypted values here
     */
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if(!$entity instanceof Profile) {
            return;
        }
        if(in_array($entity->getModStatus(), [Profile::MOD_APPROVED, Profile::MOD_DENIED])) {
            $this->dispatcher->dispatch(
                new ProfileModerated(
                    $this->decrypt($entity->getUuid()),
                    $this->decrypt($entity->getEmail()),
                    $entity->getModStatus()
                )
            );
        }
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();
        if(!$entity instanceof Profile) return;

        if(
            $args->getNewValue('modStatus') != $args->getOldValue('modStatus')
            && in_array($args->getNewValue('modStatus'), [Profile::MOD_APPROVED, Profile::MOD_DENIED])
        ) {
            $this->dispatcher->dispatch(
                new ProfileModerated(
                    $this->decrypt($entity->getUuid()),
                    $this->decrypt($entity->getEmail()),
                    $entity->getModStatus()
                )
            );
        }
    }

    protected function decrypt($value)
    {
        return strpos($value, 'def') === 0 ? $this->encrypt->reverseTransform($value) : $value;
    }

}