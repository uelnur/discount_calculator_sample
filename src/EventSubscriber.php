<?php

namespace App;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class EventSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents(): array {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void {
        if ( $event->getThrowable() instanceof BadRequestHttpException ) {
            if ( ($previousException = $event->getThrowable()->getPrevious()) instanceof ValidationFailedException ) {
                $errors = [];
                foreach ($previousException->getViolations() as $violation) {
                    $errors[$violation->getPropertyPath()] = $violation->getMessage();
                }
            } else {
                $errors = $event->getThrowable()->getMessage();
            }
            $response = new JsonResponse([
                'status' => 'error',
                'errors' => $errors,
            ]);
            $event->setResponse($response);
        }
    }
}
