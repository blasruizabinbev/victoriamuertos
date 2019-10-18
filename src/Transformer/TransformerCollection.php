<?php

namespace App\Transformer;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

class TransformerCollection
{

    /** @var array */
    private $transformers = [];

    public function __construct(RewindableGenerator $transformers)
    {
        foreach($transformers as $transformer) {
            try {
                $this->transformers[get_class($transformer)] = $transformer;
            } catch (\ReflectionException $e) {
                //Skip this transformer
            }
        }
    }

    public function get($name)
    {

        if(array_key_exists($name, $this->transformers)) {
            return $this->transformers[$name];
        }
        throw new \InvalidArgumentException();
    }

}