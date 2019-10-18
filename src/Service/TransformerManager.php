<?php

namespace App\Service;

use App\Transformer\TransformerCollection;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceAbstract;

class TransformerManager
{

    /** @var Manager */
    private $manager;

    /** @var TransformerCollection */
    protected $transformerCollection;

    public function __construct(Manager $manager, TransformerCollection $transformerCollection)
    {
        $this->manager = $manager;
        $this->transformerCollection = $transformerCollection;
    }

    /**
     * @param $entity
     * @param string $transformerClass
     * @param string $includes
     * @return array
     */
    public function transformItem($entity, $transformerClass = null, $includes = null)
    {
        return $this->transform(new Item($entity, $this->transformerCollection->get($transformerClass)), $includes);
    }

    /**
     * @param $entities
     * @param string $transformerClass
     * @param string $includes
     * @return mixed
     */
    public function transformCollection($entities, $transformerClass = null, $includes = null)
    {
        return $this->transform(new Collection($entities, $this->transformerCollection->get($transformerClass)), $includes);
    }

    /**
     * @codeCoverageIgnore
     * @param ResourceAbstract $resource
     * @param string $includes
     *
     * @return array
     */
    private function transform(ResourceAbstract $resource, $includes = null)
    {
        if (!empty($includes)) {
            $this->manager->parseIncludes($includes);
        }

        return $this->manager->createData($resource)->toArray();
    }
}