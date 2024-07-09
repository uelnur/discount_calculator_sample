<?php

namespace App\Domain\Utils;

readonly class AgeCalculator {
    public function calculateAge(\DateTimeImmutable $birthday, ?\DateTimeImmutable $now = null): int {
        if ( null === $now ) {
            $now = new \DateTimeImmutable();
        }

        return $birthday->diff($now)->y;
    }
}
