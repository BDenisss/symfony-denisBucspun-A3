<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Création d'un compte admin
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setPassword($this->passwordHasher->hashPassword(
            $admin,
            'adminpassword' // Vous devriez choisir un mot de passe plus sécurisé !
        ));
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        // Création d'articles
        for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence);
            $article->setContent($faker->paragraph);
            $article->setSlug($faker->slug);
            // Ajoutez d'autres propriétés selon votre entité Article
            
            $manager->persist($article);
        }

        $manager->flush();
    }
}
