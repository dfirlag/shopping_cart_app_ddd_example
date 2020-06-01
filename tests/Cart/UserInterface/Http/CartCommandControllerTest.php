<?php

declare(strict_types=1);

namespace App\Tests\Cart\UserInterface\Http;

use App\Cart\Infrastructure\Persistence\Mysql\Cart;
use App\Catalog\Infrastructure\Persistence\Mysql\Catalog;
use App\Product\Infrastructure\Persistence\Mysql\Product;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CartCommandControllerTest extends WebTestCase {

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
}