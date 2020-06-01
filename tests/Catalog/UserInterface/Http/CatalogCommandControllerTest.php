<?php

namespace Catalog\UserInterface\Http;

use App\Catalog\Infrastructure\Persistence\Mysql\Catalog;
use App\Product\Infrastructure\Persistence\Mysql\Product;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CatalogCommandControllerTest extends WebTestCase {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    public function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
                                      ->get('doctrine')
                                      ->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }

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