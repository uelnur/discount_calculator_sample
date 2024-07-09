<?php

namespace App\Tests\Domain\DiscountCalculator;

use App\Domain\DiscountCalculator\Discount;
use PHPUnit\Framework\TestCase;

class DiscountTest extends TestCase {
    public function testDiscount(): void {
        $discount = new Discount(30, 4500);
        $this->assertEquals(4500, $discount->calcDiscountedPrice(15001));
        $this->assertEquals(4500, $discount->calcDiscountedPrice(16000));

        $discount = new Discount(80, 0);
        $this->assertEquals(80, $discount->calcDiscountedPrice(100));
    }
}
