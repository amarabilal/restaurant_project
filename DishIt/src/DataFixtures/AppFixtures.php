<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Menu;
use App\Entity\Reservation;
use App\Entity\Restaurant;
use App\Entity\RestaurantTable;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Categories
        $category1 = new Category();
        $category1->setName('Italian');
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName('French');
        $manager->persist($category2);

        // Admin User
        $admin = new User();
        $admin->setEmail('admin@example.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordHasher->hashPassword($admin, 'password'));
        $manager->persist($admin);

        // Gérant User
        $gerant = new User();
        $gerant->setEmail('gerant@example.com')
            ->setRoles(['ROLE_GERANT'])
            ->setPassword($this->passwordHasher->hashPassword($gerant, 'password'));
        $manager->persist($gerant);

        // Client User
        $user = new User();
        $user->setEmail('user@example.com')
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $manager->persist($user);

        // Restaurant
        $restaurant = new Restaurant();
        $restaurant->setName('La Bella Vita')
            ->setAddress('123 Main Street')
            ->setPhone('0123456789')
            ->setCapacity(50)
            ->setGerant($gerant); // Assigner un gérant
        $restaurant->addCategory($category1);
        $manager->persist($restaurant);

        // Tables
        for ($i = 1; $i <= 5; $i++) {
            $table = new RestaurantTable();
            $table->setNumber($i)
                ->setSeats(4)
                ->setIsAvailable(true)
                ->setRestaurant($restaurant);
            $manager->persist($table);
        }

        // Menu
        $menu = new Menu();
        $menu->setTitle('Pizza Margherita')
            ->setDescription('Tomato, mozzarella, and basil')
            ->setPrice(12.5)
            ->setRestaurant($restaurant);
        $manager->persist($menu);

        // Reservation
        $reservation = new Reservation();
        $reservation->setDate(new \DateTime('tomorrow 19:00'))
            ->setGuests(4)
            ->setRestaurant($restaurant)
            ->setUser($user)
            ->setTable($table);
        $manager->persist($reservation);

        // Review
        $review = new Review();
        $review->setRating(5)
            ->setComment('Excellent service and food!')
            ->setCreatedAt(new \DateTime('now'))
            ->setRestaurant($restaurant)
            ->setUser($user);
        $manager->persist($review);

        $manager->flush();
    }
}
