<?php

namespace App\Controller;

use App\Entity\GenreCollection;
use App\Repository\CategoryCollectionRepository;
use App\Repository\GenreCollectionRepository;
use Cocur\Slugify\Slugify;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gestion-super-collect/genre', name: 'admin_genre_')]
class AdminGenreController extends AbstractController
{
    private $genreRepository;
    private $em;
    private $categoryCollectionRepository;

    public function __construct(GenreCollectionRepository $genreCollectionRepository, EntityManagerInterface $em,CategoryCollectionRepository $categoryCollectionRepository)
    {
        $this->genreRepository = $genreCollectionRepository;
        $this->em = $em;
        $this->categoryCollectionRepository = $categoryCollectionRepository;
    }

    #[Route('/ajout', name: 'add')]
    public function Add(Request $request): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $nameGenre = $data['nameGenre'];
        $category = $this->categoryCollectionRepository->findOneBy(['id'=>$data['idCategory']]);
        $genreExist = $this->genreRepository->findBy(['name'=>$nameGenre,'categoryCollection'=>$category]);
        if ($genreExist) {
            return $this->json(['message'=>'Ce genre existe déjà pour cette catégorie'], 400);
        }
        $newGenre = new GenreCollection();
        $newGenre->setName($nameGenre)->setCategoryCollection($category);
        $dateNow = new DateTime('now');
        $slugify = new Slugify();
        $newGenre->setDateCreate($dateNow)->setDateModifie($dateNow)->setSlug($slugify->slugify($newGenre->getName()));
        $this->em->persist($newGenre);
        $this->em->flush();
        return $this->json(['idGenre'=>$newGenre->getId()],200);
    }

    #[Route('/editer', name: 'edit')]
    public function categoryEdit(Request $request): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $nameGenre = $data['genre'];
        $genre = $this->genreRepository->findOneBy(['id'=>$data['idGenre']]);
        if (!$genre) {
            return $this->json(['message'=>'Impossible de trouver se genre'],400);
        }
        $dateNow = new DateTime('now');
        $slugify = new Slugify();
        $genre->setName($nameGenre);
        $genreExist = $this->genreRepository->findBy(['name'=>$genre->getName(),'categoryCollection'=>$data['idCategory']]);
        if ($genreExist) {
            return $this->json(['message'=>'Ce genre existe déjà pour cette catégorie'], 400);
        }
        $genre->setDateModifie($dateNow)->setSlug($slugify->slugify($genre->getName()));
        $this->em->persist($genre);
        $this->em->flush();
        return $this->json([],200);
    }

    #[Route('/supprimer/{idCategory}/{idGenre}', name: 'delete')]
    public function categoryDelete($idCategory,$idGenre): Response
    {
        $genre = $this->genreRepository->findOneBy(['id'=>$idGenre]);
        $category = $this->categoryCollectionRepository->findOneBy(['id'=>$idCategory]);
        if (!$genre) {
            $this->addFlash('error','Impossible de trouver le genre sélectionner');
            return $this->redirectToRoute('admin_category_edit',['slugCategory'=>$category->getSlug()]);
        }
        $this->em->remove($genre);
        $this->em->flush();
        $this->addFlash('success','Le genre à bien était supprimé');
        return $this->redirectToRoute('admin_category_edit',['slugCategory'=>$category->getSlug()]);
    }
}