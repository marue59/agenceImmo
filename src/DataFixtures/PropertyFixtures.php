<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 20; $i++) {
            $property = new Property();
            $property->setTitle("title-$i");
            $property->setAdress("$i rue verte");
            $property->setPostalCode("62231");
            $property->setCity("coquelles");
            $property->setBedrooms(2);
            $property->setDescription("description du bien $i");
            $property->setRooms(4);
            $property->setHeat(1);
            $property->setPrice(200000);
            $property->setSold(0);
            $property->setSurface(100);

            $manager->persist($property);
        }
        $manager->flush();
    }
}
