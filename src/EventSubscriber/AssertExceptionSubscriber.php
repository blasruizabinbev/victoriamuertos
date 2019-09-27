<?php

namespace App\EventSubscriber;

use Assert\LazyAssertionException;
use App\Exceptions\AssertException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AssertExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return array(
            KernelEvents::EXCEPTION => [
                ['onException', 600],
            ],
        );
    }
    public function onException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();
        if ($exception instanceof LazyAssertionException) {
            throw new AssertException('', $exception->getErrorExceptions());
        }
    }
}