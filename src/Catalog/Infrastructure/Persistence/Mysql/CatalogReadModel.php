<?php

declare(strict_types=1);

namespace App\Catalog\Infrastructure\Persistence\Mysql;

use App\Catalog\Domain\Catalog\Persistence\CatalogReadModelInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Catalog\Infrastructure\Persistence\Mysql\Repository\CatalogReadModelRepository")
 * @ORM\EntityListeners({"App\Product\Infrastructure\Persistence\Mysql\Listener\CatalogReadModelListener"})
 * @ORM\HasLifecycleCallbacks
 */
class CatalogReadModel implements CatalogReadModelInterface {
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="App\Catalog\Infrastructure\Persistence\Mysql\Catalog")
     * @ORM\JoinColumn(name="catalog_id", referencedColumnName="id")
     */
    private $catalog;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="App\Product\Infrastructure\Persistence\Mysql\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(type="string", length=255)
     */
    private $productName;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(type="decimal", precision=20, scale=0)
     */
    private $productPrice;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(type="string", length=3)
     */
    private $currency;

    /**
     * @var int
     */
    private $catalogId;

    /**
     * @var int
     */
    private $productId;

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
     * @return
     */
    public function getCatalog() {
        return $this->catalog;
    }

    /**
     * @param $catalog
     */
    public function setCatalog($catalog): void {
        $this->catalog = $catalog;
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
     * @return
     */
    public function getProduct() {
        return $this->product;
    }

    /**
     * @param $product
     */
    public function setProduct($product): void {
        $this->product = $product;
    }

    /**
     * @return string
     */
    public function getProductName(): string {
        return $this->productName;
    }

    /**
     * @param string $productName
     */
    public function setProductName(string $productName): void {
        $this->productName = $productName;
    }

    /**
     * @return string
     */
    public function getProductPrice(): string {
        return $this->productPrice;
    }

    /**
     * @param string $productPrice
     */
    public function setProductPrice(string $productPrice): void {
        $this->productPrice = $productPrice;
    }

    /**
     * @return string
     */
    public function getCurrency(): string {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void {
        $this->currency = $currency;
    }

    /**
     * @param int $catalogId
     */
    public function setCatalogId(int $catalogId): void {
        $this->catalogId = $catalogId;
    }

    /**
     * @return int
     */
    public function getProductId(): int {
        return $this->productId;
    }

    /**
     * @param int $productId
     */
    public function setProductId(int $productId): void {
        $this->productId = $productId;
    }
}