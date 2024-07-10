<?php

namespace App;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

readonly class KernelEventSubscriber implements EventSubscriberInterface {
    public function __construct(
        private SerializerInterface $serializer,
    ) {}

    public static function getSubscribedEvents(): array {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
            KernelEvents::VIEW => 'onKernelView',
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

    public function onKernelView(ViewEvent $event): void {
        if ( !$event->getControllerResult() instanceof Response) {
            $event->setResponse(JsonResponse::fromJsonString($this->serializer->serialize($event->getControllerResult(), 'json')));
        }
    }
}
