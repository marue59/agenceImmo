<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i <= 100; $i++) {
            $property = new Property();
            $property->setTitle($faker->words(3, true));
            $property->setAdress($faker->address);
            $property->setPostalCode($faker->postCode);
            $property->setCity($faker->city);
            $property->setBedrooms($faker->numberBetween(1, 9));
            $property->setDescription($faker->sentences(4, true));
            $property->setRooms($faker->numberBetween(2, 10));
            $property->setHeat($faker->numberBetween(0, count(Property::HEAT) - 1));
            $property->setPrice($faker->numberBetween(50000, 1000000));
            $property->setSold(false);
            $property->setSurface($faker->numberBetween(20, 350));

            $manager->persist($property);
        }
        $manager->flush();
    }
}
