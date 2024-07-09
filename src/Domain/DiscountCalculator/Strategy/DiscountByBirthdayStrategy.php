<?php

namespace App\Domain\DiscountCalculator\Strategy;

use App\Domain\DiscountCalculator\Discount;
use App\Domain\DiscountCalculator\DiscountRequest;
use App\Domain\DiscountCalculator\DiscountStrategyInterface;
use App\Domain\Utils\AgeCalculator;

readonly class DiscountByBirthdayStrategy implements DiscountStrategyInterface {
    private const DISCOUNT_OPTIONS = [
        [
            'percent' => 100,
            'maxDiscountedPrice' => 0,
        ],
        [
            'percent' => 80,
            'maxDiscountedPrice' => 0,
        ],
        [
            'percent' => 30,
            'maxDiscountedPrice' => 4500,
        ],
        [
            'percent' => 10,
            'maxDiscountedPrice' => 0,
        ],
    ];

    public function __construct(
        private AgeCalculator $ageCalculator,
    ) {}

    public function buildDiscount(DiscountRequest $request): ?Discount {
        $age = $this->ageCalculator->calculateAge($request->birthday, $request->tripStartDate);

        if ( $age >= 18 ) {
            return null;
        }

        $discountKey = match(true) {
            $age < 3 => 0,
            $age < 6 => 1,
            $age < 12 => 2,
            default => 3,
        };

        return new Discount(self::DISCOUNT_OPTIONS[$discountKey]['percent'], self::DISCOUNT_OPTIONS[$discountKey]['maxDiscountedPrice']);
    }
}
