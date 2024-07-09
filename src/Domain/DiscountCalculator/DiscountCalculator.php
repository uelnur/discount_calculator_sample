<?php

namespace App\Domain\DiscountCalculator;

readonly class DiscountCalculator {
    public function __construct(
        /** @var array<DiscountStrategyInterface> $strategies */
        private iterable $strategies = [],
    ) {}

    public function calculateDiscount(DiscountRequest $request): DiscountResponse {
        $response = new DiscountResponse($request->basePrice);

        foreach ($this->strategies as $strategy) {
            $discount = $strategy->buildDiscount($request);

            if (!$discount) {
                continue;
            }

            $response->addDiscount($discount);
        }

        return $response;
    }
}
