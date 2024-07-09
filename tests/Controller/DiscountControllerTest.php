<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DiscountControllerTest extends WebTestCase {
    public function test(): void {
        $client = static::createClient();

        $client->request('GET', '/api/discount-calculator', [
            'basePrice' => 100000,
            'tripStartDate' => '2024-04-01',
            'birthday' => '2006-07-09',
            'paymentDate' => '2024-01-14',
        ]);
        $this->assertResponseIsSuccessful();
        $responseData = json_decode((string)$client->getResponse()->getContent(), true);
        $this->assertEquals(88500, $responseData['finalPrice']);

        $client->request('GET', '/api/discount-calculator', [
            //'basePrice' => 100000,
            //'tripStartDate' => '2024-04-01',
            //'birthday' => '2006-07-09',
            'paymentDate' => '2024-01-14',
        ]);
        $this->assertResponseStatusCodeSame(400);
        $responseData = json_decode((string)$client->getResponse()->getContent(), true);
    }
}
