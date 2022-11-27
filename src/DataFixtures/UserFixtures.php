<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 3; $i++) {
            $user = new User();
            $user->setEmail("user$i@test.fr");
            $user->setRoles(['ROLE_USER']);
            $password = $this->hasher->hashPassword($user, '1234');
            $user->setPassword($password);


            if ($i == 0) {
                $user->setEmail('admin@test.fr');
                $user->setRoles(['ROLE_ADMIN']);
            }
            $manager->persist($user);
        }
        $manager->flush();
    }
}
