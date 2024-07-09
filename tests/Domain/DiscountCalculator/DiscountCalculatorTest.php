<?php

namespace App\Tests\Domain\DiscountCalculator;

use App\Domain\DiscountCalculator\DiscountCalculator;
use App\Domain\DiscountCalculator\DiscountRequest;
use App\Domain\DiscountCalculator\DiscountResponse;
use PHPUnit\Framework\TestCase;

class DiscountCalculatorTest extends TestCase {
    public function testDiscountCalculator(): void {
        $calculator = new DiscountCalculator([
            new TestDiscountStrategy(10),
            new TestDiscountStrategy(30, 4500),
            new TestEmptyDiscountStrategy(),
        ]);

        $request = new DiscountRequest(100000, new \DateTimeImmutable(), new \DateTimeImmutable());
        $response = $calculator->calculateDiscount($request);

        $this->assertInstanceOf(DiscountResponse::class, $response);
        $this->assertEquals(100000, $response->getBasePrice());
        $this->assertEquals(85500, $response->getFinalPrice());
        $this->assertEquals(14500, $response->getDiscountedPrice());
        $this->assertEquals(40, $response->getDiscountPercent());
        $this->assertCount(2, $response->getDiscounts());
    }
}
