<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Persistence\Mysql;

use App\Cart\Domain\Cart\Persitence\Mysql\CartModelInterface;
use Money\Money;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Cart\Infrastructure\Persistence\Mysql\Repository\CartRepository")
 * @ORM\EntityListeners({"App\Product\Infrastructure\Persistence\Mysql\Listener\CartListener"})
 * @ORM\HasLifecycleCallbacks
 */
class Cart implements CartModelInterface {

    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Product\Infrastructure\Persistence\Mysql\Product")
     * @ORM\JoinTable(name="cart_product",
     *      joinColumns={@ORM\JoinColumn(name="cart_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     *      )
     */
    private $products;

    /**
     * @var Money
     */
    private $totalPrice;

    /**
     * @var array
     */
    private $productIds = [];

    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string {
        return (string)$this->id;
    }

    /**
     * @param string $uuid
     */
    public function setId(string $uuid): void {
        $this->id = $uuid;
    }

    /**
     * @param int $productId
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

    /**
     * @return Money
     */
    public function getTotalPrice(): Money {
        return $this->totalPrice;
    }

    /**
     * @param Money $totalPrice
     */
    public function setTotalPrice(Money $totalPrice): void {
        $this->totalPrice = $totalPrice;
    }
}