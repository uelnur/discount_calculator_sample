<?php

namespace App\Tests\Domain\DiscountCalculator;

use App\Domain\DiscountCalculator\Discount;
use App\Domain\DiscountCalculator\DiscountRequest;
use App\Domain\DiscountCalculator\DiscountStrategyInterface;

readonly class TestEmptyDiscountStrategy implements DiscountStrategyInterface {
    public function buildDiscount(DiscountRequest $request): ?Discount {
        return null;
    }
}
