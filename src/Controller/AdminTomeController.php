<?php

namespace App\Controller;

use DateTime;
use Cocur\Slugify\Slugify;
use App\Entity\TomeCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CollectionLibraryRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TomeCollectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/gestion-super-collect/tome', name: 'admin_tome_')]
class AdminTomeController extends AbstractController
{
    private $collectionRepository;
    private $tomeRepository;
    private $em;

    public function __construct(CollectionLibraryRepository $collectionLibraryRepository,EntityManagerInterface $em,TomeCollectionRepository $tomeCollectionRepository)
    {
        $this->collectionRepository = $collectionLibraryRepository;
        $this->tomeRepository = $tomeCollectionRepository;
        $this->em = $em;
    }

    #[Route('/ajout', name: 'add')]
    public function tomeAdd(Request $request): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $nameTome = $data['tome'];
        if ($nameTome == "") {
            return $this->json(['message'=>'Une erreur c\'est produit'], 400);
        }
        $collection = $this->collectionRepository->findOneBy(['id'=>$data['collection']]);
        $tomeExist = $this->tomeRepository->findBy(['name'=>$nameTome,'collectionLibrary'=>$collection]);
        if ($tomeExist) {
            return $this->json(['message'=>'Ce tome existe déjà pour cette collection'], 400);
        }
        $newTome = new TomeCollection();
        $newTome->setName($nameTome)->setCollectionLibrary($collection);
        $dateNow = new DateTime('now');
        $slugify = new Slugify();
        $newTome->setDateCreate($dateNow)->setDateModifie($dateNow)->setSlug($slugify->slugify($newTome->getName()));
        $this->em->persist($newTome);
        $collection->setNumberTome($collection->getNumberTome() + 1);
        $this->em->persist($collection);
        $this->em->flush();
        return $this->json(['idTome'=>$newTome->getId()],200);
    }

    #[Route('/editer', name: 'edit')]
    public function tomeEdit(Request $request): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $nameTome = $data['tome'];
        $tome = $this->tomeRepository->findOneBy(['id'=>$data['idTome']]);
        if (!$tome) {
            return $this->json(['message'=>'Impossible de trouver se tome'],400);
        }
        $tomeExist = $this->tomeRepository->findBy(['name'=>$nameTome,'collectionLibrary'=>$tome->getCollectionLibrary()]);
        if ($tomeExist) {
            return $this->json(['message'=>'Ce tome existe déjà pour cette collection'], 400);
        }
        $dateNow = new DateTime('now');
        $slugify = new Slugify();
        $tome->setName($nameTome)->setDateModifie($dateNow)->setSlug($slugify->slugify($tome->getName()));
        $this->em->persist($tome);
        $this->em->flush();
        return $this->json([],200);
    }

    #[Route('/{idCollection}/supprimer/{idTome}', name: 'delete')]
    public function tomeDelete($idCollection,$idTome): Response
    {
        $collection = $this->collectionRepository->findOneBy(['id'=>$idCollection]);
        $tome = $this->tomeRepository->findOneBy(['id'=>$idTome]);
        if (!$tome) {
            $this->addFlash('error','Impossible de trouver le tome sélectionner');
            return $this->redirectToRoute('admin_collection_edit',['slugCategory'=>$collection->getCategoryCollection()->getSlug(),'slugCollection'=>$collection->getSlug()]);
        }
        $collection->setNumberTome($collection->getNumberTome() - 1);
        $this->em->remove($tome);
        $this->em->flush();
        $this->addFlash('success','Le tome à bien était supprimé');
        return $this->redirectToRoute('admin_collection_edit',['slugCategory'=>$collection->getCategoryCollection()->getSlug(),'slugCollection'=>$collection->getSlug()]);
    }
}