<?php

namespace App\Catalog\Infrastructure\Persistence\Mysql;

use App\Catalog\Domain\Catalog\Persistence\CatalogModelInterface;
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
 * @ORM\Entity(repositoryClass="App\Catalog\Infrastructure\Persistence\Mysql\Repository\CatalogRepository")
 * @EntityListeners({"Product\Infrastructure\Persistence\Mysql\Listener\CatalogListener"})
 * @HasLifecycleCallbacks
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
     * @ManyToMany(targetEntity="App\Product\Infrastructure\Persistence\Mysql\Product")
     * @JoinTable(name="catalog_product",
     *      joinColumns={@JoinColumn(name="catalog_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="product_id", referencedColumnName="id")}
     *      )
     */
    private $products;

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
}