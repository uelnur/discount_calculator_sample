<?php

namespace App\Tests\Domain\DiscountCalculator\Strategy;

use App\Domain\DiscountCalculator\Discount;
use App\Domain\DiscountCalculator\DiscountRequest;
use App\Domain\DiscountCalculator\Strategy\DiscountByBirthdayStrategy;
use App\Domain\Utils\AgeCalculator;
use PHPUnit\Framework\TestCase;

class DiscountByBirthdayStrategyTest extends TestCase {
    public function testBirthdayStrategy(): void {
        $tripStartDate = '2024-07-09';
        $result = $this->testStrategy('2006-07-09', $tripStartDate);
        $this->assertNull($result);

        $result = $this->testStrategy('2006-07-10', $tripStartDate);
        $this->assertInstanceOf(Discount::class, $result);
        $this->assertEquals(10, $result->percent);
        $this->assertEquals(0, $result->maxDiscountedPrice);

        $result = $this->testStrategy('2012-07-10', $tripStartDate);
        $this->assertInstanceOf(Discount::class, $result);
        $this->assertEquals(30, $result->percent);
        $this->assertEquals(4500, $result->maxDiscountedPrice);

        $result = $this->testStrategy('2012-07-10', $tripStartDate);
        $this->assertInstanceOf(Discount::class, $result);
        $this->assertEquals(30, $result->percent);
        $this->assertEquals(4500, $result->maxDiscountedPrice);
    }

    private function testStrategy(string $birthday, string $tripStartDate): ?Discount {
        $strategy = new DiscountByBirthdayStrategy(new AgeCalculator());

        $request = new DiscountRequest(0, new \DateTimeImmutable($birthday), new \DateTimeImmutable($tripStartDate), null);
        return $strategy->buildDiscount($request);
    }
}
