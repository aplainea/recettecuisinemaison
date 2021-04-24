<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 *
 * @ApiResource(
 *     collectionOperations = {
 *          "get" = {
 *              "normalization_context" = {"groups" = {"read:orders"}}
 *          },
 *          "post" = {
 *              "denormalization_context" = {"groups" = {"write:orders"}}
 *          }
 *     },
 *     itemOperations = {
 *          "get" = {
 *              "normalization_context" = {"groups" = {"read:orders", "read:order"}}
 *          },
 *          "put" = {
 *              "denormalization_context" = {"groups" = {"write:order"}}
 *          },
 *          "patch"
 *     }
 * )
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"read:orders"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups({"read:orders", "write:orders", "write:order"})
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"read:orders", "write:orders", "write:order"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Recipe::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"read:orders", "write:orders", "write:order"})
     */
    private $recipe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function __toString(): string
    {
        return "Commande " . $this->getId();
    }
}
