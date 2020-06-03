<?php

namespace App\Tests\Catalog\UserInterface\Http;

use App\Catalog\Infrastructure\Persistence\Mysql\Catalog;
use App\Catalog\Infrastructure\Persistence\Mysql\CatalogReadModel;
use App\Product\Infrastructure\Persistence\Mysql\Product;
use App\Tests\Shared\Application\UserInterface\Http\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Response;

class CatalogCommandControllerTest extends AbstractControllerTest {

    public function testAddProductToCatalogReturnStatus200()
    {
        $product = new Product();
        $product->setName("test123");
        $product->setPrice("123");
        $product->setCurrency("PLN");

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $catalog = new Catalog();
        $catalog->setName('Tested catalog');

        $this->entityManager->persist($catalog);
        $this->entityManager->flush();

        $client = static::createClient();
        $client->request('POST', "/catalog/addProduct/{$catalog->getId()}",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => $product->getId()])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        /** @var Catalog $loadedCatalog */
        $loadedCatalog = $this->entityManager->getRepository(Catalog::class)
                                             ->find($catalog->getId());

        $this->assertEquals($loadedCatalog->getProductIds(), [$product->getId()]);
    }

    public function testCreateCatalogReadModel()
    {
        $product = new Product();
        $product->setName("test123");
        $product->setPrice("123");
        $product->setCurrency("PLN");

        $this->entityManager->persist($product);

        $catalog = new Catalog();
        $catalog->setName('Tested catalog');

        $this->entityManager->persist($catalog);
        $this->entityManager->flush();

        $client = static::createClient();
        $client->request('POST', "/catalog/addProduct/{$catalog->getId()}",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => $product->getId()])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        /** @var CatalogReadModel $loadedCatalog */
        $loadedCatalog = $this->entityManager
            ->getRepository(CatalogReadModel::class)
            ->findOneBy(['catalog' => $catalog->getId()]);

        $this->assertEquals($loadedCatalog->getCatalog()->getId(), $catalog->getId());
        $this->assertEquals($loadedCatalog->getName(), $catalog->getName());
        $this->assertEquals($loadedCatalog->getProduct()->getId(), $product->getId());
        $this->assertEquals($loadedCatalog->getProductName(), $product->getName());
        $this->assertEquals($loadedCatalog->getProductPrice(), $product->getPrice());
        $this->assertEquals($loadedCatalog->getCurrency(), $product->getCurrency());
    }

    public function testCreateCatalogReadModelAddAndRemoveProductFromCatalog()
    {
        $product1 = new Product();
        $product1->setName("test123");
        $product1->setPrice("123");
        $product1->setCurrency("PLN");

        $this->entityManager->persist($product1);

        $product2 = new Product();
        $product2->setName("test123");
        $product2->setPrice("123");
        $product2->setCurrency("PLN");

        $this->entityManager->persist($product2);

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

        $client->request('POST', "/catalog/addProduct/{$catalog->getId()}",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => $product2->getId()])
        );

        $client->request('POST', "/catalog/removeProduct/{$catalog->getId()}",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => $product1->getId()])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        /** @var CatalogReadModel $loadedCatalog */
        $loadedCatalog = $this->entityManager
            ->getRepository(CatalogReadModel::class)
            ->findOneBy(['catalog' => $catalog->getId()]);

        $this->assertEquals($loadedCatalog->getCatalog()->getId(), $catalog->getId());
        $this->assertEquals($loadedCatalog->getName(), $catalog->getName());
        $this->assertEquals($loadedCatalog->getProduct()->getId(), $product2->getId());
        $this->assertEquals($loadedCatalog->getProductName(), $product2->getName());
        $this->assertEquals($loadedCatalog->getProductPrice(), $product2->getPrice());
        $this->assertEquals($loadedCatalog->getCurrency(), $product2->getCurrency());
    }

    public function testRemoveProductFromCatalogReturnStatus200()
    {
        $product = new Product();
        $product->setName("test123");
        $product->setPrice("123");
        $product->setCurrency("PLN");

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $catalog = new Catalog();
        $catalog->setName('Tested catalog');
        $catalog->setProducts([$product]);

        $this->entityManager->persist($catalog);
        $this->entityManager->flush();

        $client = static::createClient();
        $client->request('POST', "/catalog/removeProduct/{$catalog->getId()}",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => $product->getId()])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        /** @var Catalog $loadedCatalog */
        $loadedCatalog = $this->entityManager->getRepository(Catalog::class)
                                             ->find($catalog->getId());

        $this->assertEquals($loadedCatalog->getProductIds(), []);
    }
}