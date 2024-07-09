<?php

namespace App\Tests\Domain\Utils;

use App\Domain\Utils\AgeCalculator;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class AgeCalculatorTest extends TestCase {
    public function testAgeCalculation(): void {
        $now = '2024-07-09';

        $this->testAge(0, $now, $now);
        $this->testAge(0, '2023-07-10', $now);

        $this->testAge(1, '2023-07-09', $now);
        $this->testAge(1, '2022-07-10', $now);

        $this->testAge(2, '2021-07-10', $now);
        $this->testAge(3, '2021-07-09', $now);
        $this->testAge(3, '2020-07-10', $now);

        $this->testAge(17, '2006-07-10', $now);
        $this->testAge(18, '2006-07-09', $now);
        $this->testAge(18, '2006-07-08', $now);
    }

    private function testAge(int $expectedAge, string $birthday, string $now): void {
        $calculator = new AgeCalculator();
        $now = new DateTimeImmutable($now);
        $this->assertEquals($expectedAge, $calculator->calculateAge(new DateTimeImmutable($birthday), $now));
    }
}
