<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $hasherInterface)
    {
        $this->hasher = $hasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        //tạo tài khoản với ROLE_ADMIN
        $user = new User;
        $user->setUsername("admin");  //unique
        $user->setRoles(["ROLE_ADMIN"]); //security.yaml
        $user->setPassword($this->hasher->hashPassword($user,"shop123"));  //__construct
        $manager->persist($user);

        //tạo tài khoản với ROLE_CUSTOMER
        $user = new User;
        $user->setUsername("client");
        $user->setRoles(["ROLE_CUSTOMER"]);
        $user->setPassword($this->hasher->hashPassword($user,"thanh"));
        $manager->persist($user);

        $manager->flush();
    }
}
