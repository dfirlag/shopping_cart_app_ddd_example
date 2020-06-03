<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Persistence\Mysql;

use App\Product\Domain\Product\Persistence\ProductModel;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Product\Infrastructure\Persistence\Mysql\Repository\ProductRepository")
 * @ORM\EntityListeners({"App\Cart\Infrastructure\Persistence\Mysql\Listener\ProductListener"})
 */
class Product implements ProductModel {

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
     * @var string
     * @Assert\NotNull
     * @ORM\Column(type="decimal", precision=20, scale=0)
     */
    private $price;

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
     * @return string
     */
    public function getPrice(): string {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void {
        $this->price = $price;
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