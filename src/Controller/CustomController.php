<?php

namespace App\Controller;

use App\Repository\CategoryCollectionRepository;
use App\Repository\CollectionUserRepository;
use App\Repository\TomeUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomController extends AbstractController
{
    private $collectionUserRepository;
    private $categoryRepository;
    private $tomeUserRepository;
    public function __construct(CollectionUserRepository $collectionUserRepository,CategoryCollectionRepository $categoryCollectionRepository,TomeUserRepository $tomeUserRepository){
        $this->collectionUserRepository = $collectionUserRepository;
        $this->categoryRepository = $categoryCollectionRepository;
        $this->tomeUserRepository = $tomeUserRepository;
    } 

    #[Route('/profil', name: 'profil_home')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        $categories = $this->categoryRepository->findAll();
        $collections = $this->collectionUserRepository->findBy(['user'=>$user]);
        $tomes =$this->tomeUserRepository->findBy(['user'=>$user]);
        $infosCollections = [];
        $infosTomes = [];
        array_push($infosCollections,['name'=>'Total','number'=>count($collections)]);
        array_push($infosTomes,['name'=>'Total','number'=>count($tomes)]);
        foreach ($categories as $category) {
            $collectionsCategory = $this->collectionUserRepository->findBy(['user'=>$user,'categoryCollection'=>$category]);
            $numberTome = 0;
            foreach ($collectionsCategory as $collection) {
                $numberTome = $numberTome + count($this->tomeUserRepository->findBy(['collectionLibrary'=>$collection->getCollectionLibrary(),'user'=>$user]));
            }
            $infocollection = ['name'=>$category->getName(),'number'=>count($collectionsCategory)];
            array_push($infosCollections,$infocollection);

            $infoTome = ['name'=>$category->getName(),'number'=>$numberTome];
            array_push($infosTomes,$infoTome);
        }
        return $this->render('frontend/custom/profil.html.twig',[
            'collections' => $collections,
            'infosCollections' => $infosCollections,
            'infosTomes' => $infosTomes,
        ]);
    }
}