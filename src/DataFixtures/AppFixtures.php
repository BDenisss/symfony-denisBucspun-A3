<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
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


        $existingAdmin = $manager->getRepository(User::class)->findOneBy(['email' => 'admin@example.com']);
        if (!$existingAdmin) {
            $admin = new User();
            $admin->setEmail('admin@example.com');
            $admin->setPassword($this->passwordHasher->hashPassword(
                $admin,
                'adminpassword'
            ));
            $admin->setRoles(['ROLE_ADMIN']);
            $manager->persist($admin);
        }

        for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence(6, true)); 
            $article->setContent($faker->paragraphs(asText: true));
            $article->setSlug($faker->unique()->slug());

            $manager->persist($article);
        }

        $manager->flush();
    }
}
