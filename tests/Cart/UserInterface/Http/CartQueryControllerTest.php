<?php

declare(strict_types=1);

namespace App\Tests\Cart\UserInterface\Http;

use App\Product\Infrastructure\Persistence\Mysql\Product;
use App\Tests\Shared\Application\UserInterface\Http\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Response;

class CartQueryControllerTest extends AbstractControllerTest {

    public function testGetCart()
    {
        $product1 = new Product();
        $product1->setName("test1");
        $product1->setPrice($amount = "111");
        $product1->setCurrency($currency = "PLN");

        $product2 = new Product();
        $product2->setName("test2");
        $product2->setPrice($amount = "222");
        $product2->setCurrency($currency = "PLN");

        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->flush();

        $client = static::createClient();
        $client->request('PUT', "/cart/createEmpty",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = json_decode($client->getResponse()->getContent(), true);
        $cartUuid = $response['cart_uuid'];

        $client->request('POST', "/cart/addProduct/$cartUuid",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => $product1->getId()])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $client->request('POST', "/cart/addProduct/$cartUuid",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => $product2->getId()])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $client->request('GET', "/cart/get/$cartUuid",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($response['cartId'], $cartUuid);
        $this->assertEquals($response['total'], $product1->getPrice() + $product2->getPrice());
        $this->assertEquals($response['products'][0]['price'], $product1->getPrice());
        $this->assertEquals($response['products'][0]['currency'], $product1->getCurrency());
        $this->assertEquals($response['products'][0]['name'], $product1->getName());
        $this->assertEquals($response['products'][0]['id'], $product1->getId());
        $this->assertEquals($response['products'][1]['price'], $product2->getPrice());
        $this->assertEquals($response['products'][1]['currency'], $product2->getCurrency());
        $this->assertEquals($response['products'][1]['name'], $product2->getName());
        $this->assertEquals($response['products'][1]['id'], $product2->getId());
    }

    public function testGetCartWithChangedProductNameAndPrice()
    {
        $product1 = new Product();
        $product1->setName("test1");
        $product1->setPrice($amount = "111");
        $product1->setCurrency($currency = "PLN");

        $this->entityManager->persist($product1);
        $this->entityManager->flush();

        $client = static::createClient();
        $client->request('PUT', "/cart/createEmpty",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = json_decode($client->getResponse()->getContent(), true);
        $cartUuid = $response['cart_uuid'];

        $client->request('POST', "/cart/addProduct/$cartUuid",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => $product1->getId()])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $product1 = $this->entityManager->getReference(Product::class, $product1->getId());
        $product1->setName('changedName');
        $product1->setPrice('321');

        $this->entityManager->persist($product1);
        $this->entityManager->flush();

        $client->request('GET', "/cart/get/$cartUuid",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($response['cartId'], $cartUuid);
        $this->assertEquals($response['total'], $product1->getPrice());
        $this->assertEquals($response['products'][0]['price'], $product1->getPrice());
        $this->assertEquals($response['products'][0]['currency'], $product1->getCurrency());
        $this->assertEquals($response['products'][0]['name'], $product1->getName());
        $this->assertEquals($response['products'][0]['id'], $product1->getId());
    }

    public function testGetCartWithRemovedProduct()
    {
        $product1 = new Product();
        $product1->setName("test1");
        $product1->setPrice($amount = "111");
        $product1->setCurrency($currency = "PLN");

        $product2 = new Product();
        $product2->setName("test2");
        $product2->setPrice($amount = "222");
        $product2->setCurrency($currency = "PLN");

        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->flush();

        $client = static::createClient();
        $client->request('PUT', "/cart/createEmpty",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = json_decode($client->getResponse()->getContent(), true);
        $cartUuid = $response['cart_uuid'];

        $client->request('POST', "/cart/addProduct/$cartUuid",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => $product1->getId()])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $client->request('POST', "/cart/addProduct/$cartUuid",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => $product2->getId()])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $client->request('POST', "/cart/removeProduct/$cartUuid",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => $product1->getId()])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $client->request('GET', "/cart/get/$cartUuid",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($response['cartId'], $cartUuid);
        $this->assertEquals($response['total'], $product1->getPrice() + $product2->getPrice());
        $this->assertEquals($response['products'][1]['price'], $product2->getPrice());
        $this->assertEquals($response['products'][1]['currency'], $product2->getCurrency());
        $this->assertEquals($response['products'][1]['name'], $product2->getName());
        $this->assertEquals($response['products'][1]['id'], $product2->getId());
    }
}