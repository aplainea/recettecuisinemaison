<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Users
        $userType = ['admin', 'user'];
        foreach ($userType as $oneuser) {
            $user = new User();
            $user->setPseudo("$oneuser");
            $user->setName("$oneuser");
            $user->setFirstname("$oneuser");
            $user->setPassword($this->encoder->encodePassword($user, "$oneuser"));
            $user->setEmail("$oneuser@$oneuser.fr");
            $user->setAvatar("/img/avatar/$oneuser.png");
            $user->setUpdated(new \DateTime());
            $user->setRoles(['ROLE_'.strtoupper($oneuser)]);
            $manager->persist($user);
        }


        // Categories
        $catName = ['Entrée', 'Plat', 'Dessert'];
        foreach ($catName as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }


        $manager->flush();
    }
}
