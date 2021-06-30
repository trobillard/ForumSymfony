<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{   
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
    $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager)
    {
            $product = new Product();
        // $manager->persist($product);
        // $user->setPassword($this->passwordHasher->hashPassword(
            // $user,
            // 'the_new_password'
    //    ));
        $manager->flush();
    }
}
