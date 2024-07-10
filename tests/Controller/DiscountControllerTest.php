<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DiscountControllerTest extends WebTestCase {
    private KernelBrowser $client;

    public function test(): void {
        $this->client = static::createClient();

        $responseData = $this->makeRequest('100000', '2024-04-01', '2006-07-09', '2024-01-14');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(88500, $responseData['finalPrice']);
        $this->assertEquals(11500, $responseData['discountedPrice']);
        $this->assertEquals(13, $responseData['discountPercent']);
        $this->assertCount(2, $responseData['discounts']);

        $birthday = (new \DateTime())->modify('-13 year');
        $responseData = $this->makeRequest('100000', '', $birthday->format('Y-m-d'), '');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(90000, $responseData['finalPrice']);
        $this->assertEquals(10000, $responseData['discountedPrice']);
        $this->assertEquals(10, $responseData['discountPercent']);
        $this->assertCount(1, $responseData['discounts']);

        $responseData = $this->makeRequest('100000', '', '', '');
        $this->assertResponseStatusCodeSame(400);
        $this->assertEquals('error', $responseData['status']);
        $this->assertCount(1, $responseData['errors']);
        $this->assertArrayHasKey('birthday', $responseData['errors']);

        $responseData = $this->makeRequest('', '', '2024-10-09', '');
        $this->assertResponseStatusCodeSame(400);
        $this->assertEquals('error', $responseData['status']);
        $this->assertCount(1, $responseData['errors']);
        $this->assertArrayHasKey('basePrice', $responseData['errors']);
    }

    private function makeRequest(string $basePrice, string $tripStartDate, string $birthday, string $paymentDate): array {
        $query = [];

        if ( $basePrice ) $query['basePrice'] = $basePrice;
        if ( $birthday ) $query['birthday'] = $birthday;
        if ( $tripStartDate ) $query['tripStartDate'] = $tripStartDate;
        if ( $paymentDate ) $query['paymentDate'] = $paymentDate;

        $this->client->request('GET', '/api/discount-calculator', $query);

        return json_decode((string)$this->client->getResponse()->getContent(), true);
    }
}
