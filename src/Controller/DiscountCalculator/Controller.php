<?php

namespace App\Controller\DiscountCalculator;

use App\Domain\DiscountCalculator\DiscountCalculator;
use App\Domain\DiscountCalculator\DiscountRequest;
use App\Domain\DiscountCalculator\DiscountResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

readonly class Controller {
    public function __construct(
        private DiscountCalculator $calculator,
    ) {}

    #[Route('/api/discount-calculator', methods: ['GET'], format: 'json')]
    public function action(
        #[MapQueryString(validationFailedStatusCode: Response::HTTP_BAD_REQUEST,)]
        DiscountRequest $discountRequest,
    ): DiscountResponse {
        return $this->calculator->calculateDiscount($discountRequest);
    }
}
