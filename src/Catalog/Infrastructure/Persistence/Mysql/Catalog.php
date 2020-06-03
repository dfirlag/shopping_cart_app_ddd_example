<?php

declare(strict_types=1);

namespace App\Catalog\Infrastructure\Persistence\Mysql;

use App\Catalog\Domain\Catalog\Persistence\CatalogModelInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Catalog\Infrastructure\Persistence\Mysql\Repository\CatalogRepository")
 * @ORM\EntityListeners({"App\Product\Infrastructure\Persistence\Mysql\Listener\CatalogListener"})
 */
class Catalog implements CatalogModelInterface {

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Product\Infrastructure\Persistence\Mysql\Product")
     * @ORM\JoinTable(name="catalog_product",
     *      joinColumns={@ORM\JoinColumn(name="catalog_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     *      )
     */
    private $products;

    /**
     * @var array
     */
    private $productIds = [];

    /**
     * Catalog constructor.
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }


    /**
     * @param mixed $products
     */
    public function addProductId(int $productId): void {
        $this->productIds[] = $productId;
    }

    /**
     * @param array $productIds
     */
    public function setProductIds(array $productIds): void {
        $this->productIds = $productIds;
    }

    /**
     * @return array
     */
    public function getProductIds(): array {
        return $this->productIds;
    }

    /**
     * @param array $products
     */
    public function setProducts(array $products): void {
        $this->products = $products;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getProducts() {
        return $this->products;
    }
}