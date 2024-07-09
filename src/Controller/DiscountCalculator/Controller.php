<?php

namespace App\Controller\DiscountCalculator;

use App\Domain\DiscountCalculator\DiscountCalculator;
use App\Domain\DiscountCalculator\DiscountRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

readonly class Controller {
    public function __construct(
        private DiscountCalculator $calculator,
        private SerializerInterface $serializer,
    ) {}

    #[Route('/api/discount-calculator', methods: ['GET'], format: 'json')]
    public function action(
        #[MapQueryString(validationFailedStatusCode: Response::HTTP_BAD_REQUEST,)] DiscountRequest $discountRequest,
    ): Response {
        $discountResponse = $this->calculator->calculateDiscount($discountRequest);

        return JsonResponse::fromJsonString($this->serializer->serialize($discountResponse, 'json'));/*[
            'finalPrice' => $discountResponse->getFinalPrice(),
            'discountedPrice' => $discountResponse->getDiscountedPrice(),
        ]);*/
    }
}
