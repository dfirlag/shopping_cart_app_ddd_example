<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Persistence\Mysql;

use App\Cart\Domain\Cart\Persitence\Mysql\CartReadModelInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Cart\Infrastructure\Persistence\Mysql\Repository\CartReadModelRepository")
 * @ORM\EntityListeners({"App\Product\Infrastructure\Persistence\Mysql\Listener\CartReadModelListener"})
 * @ORM\HasLifecycleCallbacks
 */
class CartReadModel implements CartReadModelInterface {

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
     * @ORM\Column(type="string", length=36)
     */
    private $cartId;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(type="string", length=255)
     */
    private $productName;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(type="integer")
     */
    private $productId;

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
    public function getCartId(): string {
        return $this->cartId;
    }

    /**
     * @param string $cartId
     */
    public function setCartId(string $cartId): void {
        $this->cartId = $cartId;
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
     * @return int
     */
    public function getProductId(): int {
        return (int)$this->productId;
    }

    /**
     * @param int $productId
     */
    public function setProductId(int $productId): void {
        $this->productId = $productId;
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
}