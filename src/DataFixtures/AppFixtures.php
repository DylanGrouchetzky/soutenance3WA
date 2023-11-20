<?php

namespace App\DataFixtures;

use App\Entity\CategoryCollection;
use App\Entity\CollectionLibrary;
use App\Entity\GenreCollection;
use App\Entity\ParameterWebsite;
use App\Entity\TomeCollection;
use App\Entity\User;
use Cocur\Slugify\Slugify;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hash;
    public function __construct(UserPasswordHasherInterface $hash){
        $this->hash = $hash;
    }
    public function load(ObjectManager $manager): void
    {
        $date = new DateTime();
        $slugify = new Slugify();

        $parameterWebSite = new ParameterWebsite();
        $parameterWebSite
        ->setNameWebsite('Super Collect')
        ->setLinkFacebook('https://www.facebook.com/profile.php?id=61553765727671')
        ->setLinkInstagram('https://www.instagram.com/supercollectduweb/')
        ->setEmailContact('contact@super-collect.fr')
        ->setTextDetailWebsite("Super Collect est un site web qui vous permettra d'enregistrer votre collection.
        Grâce à celui-ci, vous pourrez suivre la progression de votre collection et découvrir d'autres œuvres.
        <br><br>
        Le site est régulièrement mis à jour, vous trouverez sûrement des ouvrages que vous ne connaissez pas et qui devraient vous plaire.
        <br><br>
        Pour pouvoir ajouter des ouvrages dans votre collection, il faudra que vous soyez inscrit et connecté.");
        $manager->persist($parameterWebSite);

        $admin = new User();
        $admin
        ->setEmail('admin@admin.fr')
        ->setRoles(["ROLE_ADMIN"])
        ->setPassword($this->hash->hashPassword($admin, "admin123"))
        ->setDateCreated($date)
        ->setLastConnect($date);
        $manager->persist($admin);

        $user = new User();
        $user
        ->setEmail('user@user.fr')
        ->setRoles(["ROLE_USER"])
        ->setPassword($this->hash->hashPassword($user, 'user123'))
        ->setDateCreated($date)
        ->setLastConnect($date);
        $manager->persist($user);

        $mangaCategory = new CategoryCollection();
        $mangaCategory
        ->setDateCreate($date)
        ->setDateModifie($date)
        ->setName('Manga')
        ->setSlug($slugify->slugify('Manga'));
        $manager->persist($mangaCategory);

        $livreCategory = new CategoryCollection();
        $livreCategory
        ->setDateCreate($date)
        ->setDateModifie($date)
        ->setName('Livre')
        ->setSlug($slugify->slugify('Livre'));
        $manager->persist($livreCategory);

        $actionGenre = new GenreCollection();
        $actionGenre
        ->setDateCreate($date)
        ->setDateModifie($date)
        ->setName('Action')
        ->setCategoryCollection($mangaCategory)
        ->setSlug($slugify->slugify('Action'));
        $manager->persist($actionGenre);

        $aventureGenre = new GenreCollection();
        $aventureGenre
        ->setDateCreate($date)
        ->setDateModifie($date)
        ->setName('Aventure')
        ->setCategoryCollection($mangaCategory)
        ->setSlug($slugify->slugify('Aventure'));
        $manager->persist($aventureGenre);

        $comedieGenre = new GenreCollection();
        $comedieGenre
        ->setDateCreate($date)
        ->setDateModifie($date)
        ->setName('Comédie')
        ->setCategoryCollection($mangaCategory)
        ->setSlug($slugify->slugify('Comédie'));
        $manager->persist($comedieGenre);

        for ($i=0; $i < 30; $i++) { 
            if ($i <= 15) {
                $statusCollect = "progress";
            }else{
                $statusCollect = "finish";
            }
            $collection = new CollectionLibrary();
            $collection
            ->setName('Collection '.$i)
            ->setStatus($statusCollect)
            ->setNumberTome(6)
            ->setDescription(' Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deserunt assumenda, soluta autem libero placeat ut nulla voluptatibus voluptas mollitia iure a dignissimos excepturi modi magnam esse ipsa dolorum quasi expedita.
            Fugiat voluptatibus consequatur repudiandae, velit soluta similique mollitia pariatur iste nam accusantium voluptas, delectus in quae labore porro ipsa quam voluptate ad tempore? Non harum, labore doloremque sequi consectetur facilis. ')
            ->setSlug($slugify->slugify('Collection '.$i))
            ->addGenreCollection($actionGenre)
            ->addGenreCollection($aventureGenre)
            ->addGenreCollection($comedieGenre)
            ->setCategoryCollection($mangaCategory)
            ->setDateCreate($date)
            ->setDateModifie($date);
            $manager->persist($collection);
                for ($j=0; $j < 6; $j++) { 
                    $tome = new TomeCollection();
                    $tome
                    ->setName('Tome '.$j)
                    ->setCollectionLibrary($collection)
                    ->setDateCreate($date)
                    ->setDateModifie($date)
                    ->setSlug($slugify->slugify('Tome '.$j));
                    $manager->persist($tome);
                }
        }
        $manager->flush();
    }
}
