<?php

declare(strict_types=1);

namespace App\Tests\Cart\UserInterface\Http;

use App\Cart\Infrastructure\Persistence\Mysql\Cart;
use App\Cart\Infrastructure\Persistence\Mysql\CartReadModel;
use App\Catalog\Infrastructure\Persistence\Mysql\Catalog;
use App\Product\Infrastructure\Persistence\Mysql\Product;
use App\Tests\Shared\Application\UserInterface\Http\AbstractControllerTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CartCommandControllerTest extends AbstractControllerTest {

    public function testCreateEmptyCartReturnStatus200()
    {
        $client = static::createClient();
        $client->request('PUT', "/cart/createEmpty",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true);
        $cartUuid = $response['cart_uuid'];

        /** @var Cart $loadedCart */
        $loadedCart = $this->entityManager
            ->getRepository(Cart::class)
            ->find($cartUuid);

        $this->assertEquals($cartUuid, $loadedCart->getId());
        $this->assertTrue(uuid_is_valid($response['cart_uuid']));
    }

    public function testCreateEmptyCartAndAddProductToCart()
    {
        $product = new Product();
        $product->setName("test123");
        $product->setPrice($amount = "123");
        $product->setCurrency($currency = "PLN");

        $this->entityManager->persist($product);
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
            json_encode(['productId' => $product->getId()])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        /** @var Cart $loadedCart */
        $loadedCart= $this->entityManager->getRepository(Cart::class)
                                             ->find($cartUuid);

        $this->assertEquals($loadedCart->getProductIds(), [$product->getId()]);
        $this->assertEquals($loadedCart->getTotalPrice()->getAmount(), $amount);
        $this->assertEquals($loadedCart->getTotalPrice()->getCurrency(), $currency);
    }

    public function testCreateCartReadModel()
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

        /** @var CartReadModel[] $loadedCarts */
        $loadedCarts= $this->entityManager
            ->getRepository(CartReadModel::class)
            ->findByCartId($cartUuid);

        $this->assertEquals($loadedCarts[0]->getProductId(), $product1->getId());
        $this->assertEquals($loadedCarts[0]->getProductPrice(), $product1->getPrice());
        $this->assertEquals($loadedCarts[0]->getCurrency(), $product1->getCurrency());
        $this->assertEquals($loadedCarts[0]->getProductName(), $product1->getName());

        $this->assertEquals($loadedCarts[1]->getProductId(), $product2->getId());
        $this->assertEquals($loadedCarts[1]->getProductPrice(), $product2->getPrice());
        $this->assertEquals($loadedCarts[1]->getCurrency(), $product2->getCurrency());
        $this->assertEquals($loadedCarts[1]->getProductName(), $product2->getName());
    }

    public function testCreateEmptyCartAddProductToCartAndRemoveProductFromCart()
    {
        $product = new Product();
        $product->setName("test123");
        $product->setPrice($amount = "123");
        $product->setCurrency($currency = "PLN");

        $this->entityManager->persist($product);
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
            json_encode(['productId' => $product->getId()])
        );

        $client->request('POST', "/cart/removeProduct/$cartUuid",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => $product->getId()])
        );

        /** @var Cart $loadedCart */
        $loadedCart= $this->entityManager->getRepository(Cart::class)
                                             ->find($cartUuid);

        $this->assertEquals($loadedCart->getProductIds(), []);
        $this->assertEquals($loadedCart->getTotalPrice()->getAmount(), 0);
        $this->assertEquals($loadedCart->getTotalPrice()->getCurrency(), $currency);
    }
}