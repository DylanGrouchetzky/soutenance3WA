<?php

namespace App\Controller;

use App\Repository\CategoryCollectionRepository;
use App\Repository\CollectionLibraryRepository;
use App\Repository\GenreCollectionRepository;
use App\Repository\TomeCollectionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gestion-super-collect', name: 'admin_')]
class AdminController extends AbstractController
{
    private $userRepository;
    private $categoryRepository;
    private $genreRepository;
    private $collectionRepository;
    private $tomeCollectionRepository;

    public function __construct(UserRepository $userRepository,CategoryCollectionRepository $categoryCollectionRepository,GenreCollectionRepository $genreCollectionRepository,
    CollectionLibraryRepository $collectionLibraryRepository,TomeCollectionRepository $tomeCollectionRepository)
    {
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryCollectionRepository;
        $this->genreRepository = $genreCollectionRepository;
        $this->collectionRepository = $collectionLibraryRepository;
        $this->tomeCollectionRepository = $tomeCollectionRepository;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $numbersCategories = count($this->categoryRepository->findAll());
        $numbersGenres = count($this->genreRepository->findAll());
        $numbersCollections = count($this->collectionRepository->findAll());
        $numbersUsers = count($this->userRepository->findAll());
        $categories = $this->categoryRepository->findAll();
        $infoForCategory = [];
        foreach ($categories as $category) {
            $nameCategory = $category->getName();
            $collectionForCategory = $this->collectionRepository->findBy(['categoryCollection'=>$category]);
            $numberTomeForCategory = 0;
            foreach ($collectionForCategory as $collection) {
                $numberTomeForCategory = $numberTomeForCategory + count($this->tomeCollectionRepository->findBy(['collectionLibrary'=>$collection]));
            }
            $infoForFullCategory = ['name'=>$nameCategory,['numberCollection'=>count($collectionForCategory),'numberTome'=>$numberTomeForCategory]];
            array_push($infoForCategory,$infoForFullCategory);
        }
        $dataInfo = [
            ['name' => 'Categorie','number' => $numbersCategories],
            ['name' => 'Genre','number' => $numbersGenres],
            ['name' => 'Collection','number' => $numbersCollections],
            ['name' => 'Utilisateur','number' => $numbersUsers],
        ];
        return $this->render('admin/pages/homepage.html.twig',['infos' => $dataInfo,'infoForCategory'=>$infoForCategory]);
    }
}
