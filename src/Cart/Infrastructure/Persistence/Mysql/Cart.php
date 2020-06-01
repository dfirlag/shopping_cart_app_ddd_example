<?php

namespace App\Cart\Infrastructure\Persistence\Mysql;

use App\Cart\Domain\Cart\Persitence\Mysql\CartModelInterface;
use App\Catalog\Domain\Catalog\Persistence\CatalogModelInterface;
use Money\Money;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\EntityListeners;
use Doctrine\ORM\Mapping\PostLoad;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * @ORM\Entity(repositoryClass="App\Cart\Infrastructure\Persistence\Mysql\Repository\CartRepository")
 * @EntityListeners({"Product\Infrastructure\Persistence\Mysql\Listener\CartListener"})
 * @HasLifecycleCallbacks
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
     * @ManyToMany(targetEntity="App\Product\Infrastructure\Persistence\Mysql\Product")
     * @JoinTable(name="cart_product",
     *      joinColumns={@JoinColumn(name="cart_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="product_id", referencedColumnName="id")}
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

    /** @PostLoad */
    public function postLoad()
    {
        $this->productIds = [];

        foreach ($this->products->getIterator() as $row) {
            $this->productIds[] = $row->getId();
        }
    }

    /**
     * @return string
     */
    public function getId(): string {
        return $this->id;
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