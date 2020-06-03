<?php

declare(strict_types=1);

namespace App\Tests\Product\UserInterface\Http;

use App\Product\Infrastructure\Persistence\Mysql\Product;
use App\Tests\Shared\Application\UserInterface\Http\AbstractControllerTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductCommandControllerTest extends AbstractControllerTest {

    public function testUpdateProductNameReturnStatus200()
    {
        $product = new Product();
        $product->setName("test123");
        $product->setPrice("123");
        $product->setCurrency("PLN");

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $client = static::createClient();
        $client->request('POST', "/product/updateName/{$product->getId()}",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productName' => $newName = "test"])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        /** @var Product $loadedProduct */
        $loadedProduct = $this->entityManager->getRepository(Product::class)
            ->find($product->getId());

        $this->assertEquals($loadedProduct->getName(), $newName);
    }

    public function testUpdateProductPriceReturnStatus200()
    {
        $product = new Product();
        $product->setName("test");
        $product->setPrice("12376");
        $product->setCurrency("PLN");

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $client = static::createClient();
        $client->request('POST', "/product/updatePrice/{$product->getId()}",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'productPrice' => $newProductPrice = "10023"
            ])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        /** @var Product $loadedProduct */
        $loadedProduct = $this->entityManager->getRepository(Product::class)
            ->find($product->getId());

        $this->assertEquals($loadedProduct->getPrice(), $newProductPrice);
    }
}