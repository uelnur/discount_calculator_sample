<?php

namespace App\Domain\DiscountCalculator\Strategy;

use App\Domain\DiscountCalculator\Discount;
use App\Domain\DiscountCalculator\DiscountRequest;
use App\Domain\DiscountCalculator\DiscountStrategyInterface;
use App\Domain\DiscountCalculator\LastPaymentDateForDiscountCalculator;
use App\Domain\Utils\DateUtils;

readonly class DiscountByPaymentDateStrategy implements DiscountStrategyInterface {
    private const DISCOUNT_PERCENTS = [7, 5, 3,];

    private const MAX_DISCOUNT_PRICE = 1500;

    public function __construct(
        private LastPaymentDateForDiscountCalculator $calculator,
    ) {}

    public function buildDiscount(DiscountRequest $request): ?Discount {
        if ( !$request->paymentDate ) {
            return null;
        }

        $lastDiscountDate = $this->calculator->calculateByTripStartDate($request->tripStartDate);

        if ( $request->paymentDate > $lastDiscountDate ) {
            return null;
        }

        $percent = match(true) {
            DateUtils::decrementMonth(DateUtils::decrementMonth($lastDiscountDate)) >= $request->paymentDate => self::DISCOUNT_PERCENTS[0],
            DateUtils::decrementMonth($lastDiscountDate) >= $request->paymentDate => self::DISCOUNT_PERCENTS[1],
            default => self::DISCOUNT_PERCENTS[2],
        };

        return new Discount($percent, self::MAX_DISCOUNT_PRICE);
    }
}
