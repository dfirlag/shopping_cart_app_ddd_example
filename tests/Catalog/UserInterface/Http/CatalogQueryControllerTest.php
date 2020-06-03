<?php

namespace App\Tests\Catalog\UserInterface\Http;
use App\Catalog\Infrastructure\Persistence\Mysql\Catalog;
use App\Catalog\Infrastructure\Persistence\Mysql\CatalogReadModel;
use App\Product\Infrastructure\Persistence\Mysql\Product;
use App\Tests\Shared\Application\UserInterface\Http\AbstractControllerTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CatalogQueryControllerTest extends AbstractControllerTest {

    public function testGetCatalogReturnCorrectPaginationDto()
    {
        $product1 = new Product();
        $product1->setName("test123");
        $product1->setPrice("123");
        $product1->setCurrency("PLN");

        $this->entityManager->persist($product1);

        $catalog = new Catalog();
        $catalog->setName('Tested catalog');

        $this->entityManager->persist($catalog);
        $this->entityManager->flush();

        $client = static::createClient();
        $client->request('POST', "/catalog/addProduct/{$catalog->getId()}",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => $product1->getId()])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $client->request('GET', "/catalog/getPaginatedCatalog/{$catalog->getId()}/1",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($response['catalogId'], $catalog->getId());
        $this->assertEquals($response['products'][0]['id'], $product1->getId());
        $this->assertEquals($response['products'][0]['name'], $product1->getName());
        $this->assertEquals($response['products'][0]['price'], $product1->getPrice());
        $this->assertEquals($response['products'][0]['currency'], $product1->getCurrency());
    }
}