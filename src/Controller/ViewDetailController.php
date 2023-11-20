<?php

namespace App\Controller;

use App\Entity\TomeUser;
use App\Entity\TomeUserRead;
use App\Entity\CollectionUser;
use App\Repository\TomeUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TomeUserReadRepository;
use App\Repository\CollectionUserRepository;
use App\Repository\TomeCollectionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CollectionLibraryRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryCollectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ViewDetailController extends AbstractController
{
    private $categoryRepository;
    private $collectionRepository;
    private $tomeCollectionRepository;
    private $collectionUserRepository;
    private $em;
    private $tomeUserRepository;
    private $tomeUserReadRepository;
    public function __construct(CategoryCollectionRepository $categoryCollectionRepository,CollectionLibraryRepository $collectionLibraryRepository,
    TomeCollectionRepository $tomeCollectionRepository,CollectionUserRepository $collectionUserRepository,EntityManagerInterface $em,TomeUserRepository $tomeUserRepository,TomeUserReadRepository $tomeUserReadRepository){
        $this->categoryRepository = $categoryCollectionRepository;
        $this->collectionRepository = $collectionLibraryRepository;
        $this->tomeCollectionRepository = $tomeCollectionRepository;
        $this->collectionUserRepository = $collectionUserRepository;
        $this->em = $em;
        $this->tomeUserRepository = $tomeUserRepository;
        $this->tomeUserReadRepository = $tomeUserReadRepository;
    } 

    #[Route('/detail/{slugCategory}/{slugCollection}', name: 'detail')]
    public function detail($slugCategory,$slugCollection): Response
    {
        $category = $this->categoryRepository->findOneBy(['slug'=>$slugCategory]);
        if (!$category) {
            $this->addFlash('error','Impossible de trouver l\'oeuvre sélectionner');
            return $this->redirectToRoute('home');
        }
        $collection = $this->collectionRepository->findOneBy(['categoryCollection'=>$category,'slug'=>$slugCollection]);
        if (!$collection) {
            $this->addFlash('error','Impossible de trouver l\'oeuvre sélectionner');
            return $this->redirectToRoute('category',['slugCategory'=>$category->getSlug()]);
        }
        $moreCollection = $this->collectionRepository->getRandomCollection($category,$collection->getId());
        return $this->render('frontend/pages/detail.html.twig',[
            'category'=>$category,
            'collection'=>$collection,
            'moreCollection'=>$moreCollection,
        ]);
    }

    #[Route('/ajout-tome/utilisateur', name: 'add_tome_user')]
    public function addTome(Request $request): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);

        $category = $this->categoryRepository->findOneBy(['slug'=>$data['category']]);
        if (!$category) { 
            $this->addFlash('error','Un probléme est survenur'); 
            return $this->json([],400); 
        }
        $collection = $this->collectionRepository->findOneBy(['slug'=>$data['collection'],'categoryCollection'=>$category]);
        if (!$collection) { 
            $this->addFlash('error','Un probléme est survenur'); 
            return $this->json([],400); 
        }
        $tome = $this->tomeCollectionRepository->findOneBy(['slug'=>$data['tome'],'collectionLibrary'=>$collection]);
        if (!$tome) { 
            $this->addFlash('error','Un probléme est survenur'); 
            return $this->json([],400); 
        }
        $user = $this->getUser();
        if (!$user) { 
            $this->addFlash('error','Un probléme est survenur'); 
            return $this->json([],400); 
        }

        $collectionUserExist = $this->collectionUserRepository->findOneBy(['collectionLibrary'=>$collection,'user'=>$user]);
        if (!$collectionUserExist) {
            $newCollection = new CollectionUser();
            $newCollection->setCollectionLibrary($collection)->setUser($user)->setCategoryCollection($category);
            $this->em->persist($newCollection);
            $this->em->flush();
        }
        $userHasTome = $this->tomeUserRepository->findOneBy(['nameTome'=>$tome,'user'=>$user]);
        if ($userHasTome) {
            $this->em->remove($userHasTome);
            $this->em->flush();
            $collection1 = $this->tomeUserRepository->findBy(['collectionLibrary'=>$collection,'user'=>$user]);
            $collection2 = $this->tomeUserReadRepository->findBy(['collectionLibrary'=>$collection,'user'=>$user]);
            if (count($collection1) <= 0 && count($collection2) <= 0 ) {
                $this->em->remove($collectionUserExist);
                $this->em->flush();
            }
            $numberTomeUser = count($this->tomeUserRepository->findBy(['user'=>$user,'collectionLibrary'=>$collection]));
            return $this->json(['action'=>'remove','message'=>'Tout est ok','numberTomeUser'=>$numberTomeUser,'numberTomeColection'=>count($collection->getTomeCollections())],200);
        }else{
            $tomeUser = new TomeUser();
            $tomeUser->setNameTome($tome)->setUser($user)->setCollectionLibrary($collection);
            $this->em->persist($tomeUser);
            $this->em->flush();
            $numberTomeUser = count($this->tomeUserRepository->findBy(['user'=>$user,'collectionLibrary'=>$collection]));
            return $this->json(['action'=>'add','message'=>'Tout est ok','numberTomeUser'=>$numberTomeUser,'numberTomeColection'=>count($collection->getTomeCollections())],200);
        }
    }

    #[Route('/ajout-tome-lu/utilisateur', name: 'add_tome_user_read')]
    public function addTomeRead(Request $request): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $category = $this->categoryRepository->findOneBy(['slug'=>$data['category']]);
        if (!$category) { 
            $this->addFlash('error','Un probléme est survenur'); 
            return $this->json([],400); 
        }
        $collection = $this->collectionRepository->findOneBy(['slug'=>$data['collection'],'categoryCollection'=>$category]);
        if (!$collection) { 
            $this->addFlash('error','Un probléme est survenur'); 
            return $this->json([],400); 
        }
        $tome = $this->tomeCollectionRepository->findOneBy(['slug'=>$data['tome'],'collectionLibrary'=>$collection]);
        if (!$tome) { 
            $this->addFlash('error','Un probléme est survenur'); 
            return $this->json([],400); 
        }
        $user = $this->getUser();
        if (!$user) { 
            $this->addFlash('error','Un probléme est survenur'); 
            return $this->json([],400); 
        }

        $collectionUserExist = $this->collectionUserRepository->findOneBy(['collectionLibrary'=>$collection,'user'=>$user]);
        if (!$collectionUserExist) {
            $newCollection = new CollectionUser();
            $newCollection->setCollectionLibrary($collection)->setUser($user)->setCategoryCollection($category);
            $this->em->persist($newCollection);
            $this->em->flush();
        }
        $userHasTome = $this->tomeUserReadRepository->findOneBy(['nameTome'=>$tome,'user'=>$user]);
        if ($userHasTome) {
            $this->em->remove($userHasTome);
            $this->em->flush();
            $collection1 = $this->tomeUserRepository->findBy(['collectionLibrary'=>$collection,'user'=>$user]);
            $collection2 = $this->tomeUserReadRepository->findBy(['collectionLibrary'=>$collection,'user'=>$user]);
            if (count($collection1) <= 0 && count($collection2) <= 0 ) {
                $this->em->remove($collectionUserExist);
                $this->em->flush();
            }
            $numberTomeUserRead = count($this->tomeUserReadRepository->findBy(['user'=>$user,'collectionLibrary'=>$collection]));
            return $this->json(['action'=>'remove','message'=>'Tout est ok','numberTomeUserRead'=>$numberTomeUserRead,'numberTomeColection'=>count($collection->getTomeCollections())],200);
        }else{
            $tomeUserRead = new TomeUserRead();
            $tomeUserRead->setNameTome($tome)->setUser($user)->setCollectionLibrary($collection);
            $this->em->persist($tomeUserRead);
            $this->em->flush();
            $numberTomeUserRead = count($this->tomeUserReadRepository->findBy(['user'=>$user,'collectionLibrary'=>$collection]));
            return $this->json(['action'=>'add','message'=>'Tout est ok','numberTomeUserRead'=>$numberTomeUserRead,'numberTomeColection'=>count($collection->getTomeCollections())],200);
        }
    }
}