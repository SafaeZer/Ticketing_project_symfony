<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Ticket;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public $faker;
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        // $this->faker = Factory::create();
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->loadUser($manager);
        $manager->flush();
    }
    public function loadUser(ObjectManager $manager)
    {

        for ($i = 0; $i < 50; $i++) {

            $myUser = new User();
            $myUser->setEmail($this->faker->email);

            $roles = ['ROLE_COLLABORATOR', 'ROLE_SUPPORT'];

            $myUser->setRoles([$roles[rand(0, 2)]]);
            //$myUser->setPassword($this->passwordEncoder->encodePassword(
            //$myUser,
            //'secret'
            // ));

            $manager->persist($myUser);

            $this->addReference("user_$i", $myUser);
        }


        $manager->flush();
    }
}
