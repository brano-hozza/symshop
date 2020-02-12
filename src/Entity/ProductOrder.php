<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Mixed_;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductOrderRepository")
 */
class ProductOrder
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="order", orphanRemoval=false)
     */
    private $products;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_complete;


    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param Collection|Product[] $products
     * @return $this
     */
    public function setProducts($products):self{
        $this->products = $products;
        return $this;
    }

    public function addProduct(Product $product): self
    {
        $product->setReserved(true);
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setOrder($this);
        }
        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            if ($product->getOrder() == $this) {
                $product->setReserved(false);
                $product->setOrder(null);
            }
        }

        return $this;
    }

    public function removeProducts(): self
    {
        foreach ($this->products as $key => $product){
            $this->removeProduct($this->products[$key]);
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getIsComplete(): ?bool
    {
        return $this->is_complete;
    }

    public function setIsComplete(bool $is_complete): self
    {
        $this->is_complete = $is_complete;

        return $this;
    }

}
