<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('test@testowsky.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'password'
        ));
        $manager->persist($user);


        $admin = new User();
        $admin->setEmail('admin@testowsky.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'password'
        ));
        $manager->persist($admin);



        $manager->flush();
    }
}
