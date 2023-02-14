<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFirstname('schuame')
            ->setLastname('alex')
            ->setRoles([User::ROLE_ADMIN])
            ->setStatus(User::STATUS_ENABLED)
            ->setEmail('alex@gmailcom')
            ->setPhonenumber('695254870')
            ->setPassword($this->hasher->hashPassword($user, 'azerty'));
        $manager->persist($user);
        $manager->flush();
    }
}
