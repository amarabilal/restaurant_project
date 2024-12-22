<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $address = null;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $phone = null;

    #[ORM\Column(type: 'integer')]
    private ?int $capacity = null;

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: Menu::class, cascade: ['persist', 'remove'])]
    private Collection $menus;

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: Reservation::class, cascade: ['persist', 'remove'])]
    private Collection $reservations;

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: Review::class, cascade: ['persist', 'remove'])]
    private Collection $reviews;

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: RestaurantTable::class, cascade: ['persist', 'remove'])]
    private Collection $tables;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $gerant = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'restaurants')]
    private Collection $categories;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->tables = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function getAddress(): ?string { return $this->address; }
    public function setAddress(string $address): self { $this->address = $address; return $this; }
    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(string $phone): self { $this->phone = $phone; return $this; }
    public function getCapacity(): ?int { return $this->capacity; }
    public function setCapacity(int $capacity): self { $this->capacity = $capacity; return $this; }

    public function getMenus(): Collection { return $this->menus; }
    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setRestaurant($this);
        }
        return $this;
    }
    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            if ($menu->getRestaurant() === $this) {
                $menu->setRestaurant(null);
            }
        }
        return $this;
    }

    public function getReservations(): Collection { return $this->reservations; }
    public function getReviews(): Collection { return $this->reviews; }
    public function getTables(): Collection { return $this->tables; }
    public function getCategories(): Collection { return $this->categories; }
    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addRestaurant($this);
        }
        return $this;
    }
    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeRestaurant($this);
        }
        return $this;
    }

    public function getGerant(): ?User
    {
        return $this->gerant;
    }

    public function setGerant(?User $gerant): self
    {
        $this->gerant = $gerant;
        return $this;
    }
}
