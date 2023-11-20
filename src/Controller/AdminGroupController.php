<?php

namespace App\Controller;

use App\Entity\GroupTome;
use DateTime;
use Cocur\Slugify\Slugify;
use App\Entity\TomeCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CollectionLibraryRepository;
use App\Repository\GroupTomeRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TomeCollectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/gestion-super-collect/groupe', name: 'admin_group_')]
class AdminGroupController extends AbstractController
{
    private $collectionRepository;
    private $tomeRepository;
    private $groupTomeRepository;
    private $em;

    public function __construct(CollectionLibraryRepository $collectionLibraryRepository,EntityManagerInterface $em,TomeCollectionRepository $tomeCollectionRepository,GroupTomeRepository $groupTomeRepository)
    {
        $this->collectionRepository = $collectionLibraryRepository;
        $this->tomeRepository = $tomeCollectionRepository;
        $this->groupTomeRepository = $groupTomeRepository;
        $this->em = $em;
    }

    #[Route('/ajout', name: 'add')]
    public function groupAdd(Request $request): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $nameGroup = $data['group'];
        if ($nameGroup == "") {
            return $this->json(['message'=>'Une erreur c\'est produit'], 400);
        }
        $collection = $this->collectionRepository->findOneBy(['id'=>$data['collection']]);
        $groupExist = $this->groupTomeRepository->findBy(['name'=>$nameGroup,'collectionLibrary'=>$collection]);
        if ($groupExist) {
            return $this->json(['message'=>'Ce groupe existe déjà pour cette collection'], 400);
        }
        $newGroup = new GroupTome();
        $newGroup->setName($nameGroup)->setCollectionLibrary($collection);
        $slugify = new Slugify();
        $newGroup->setSlug($slugify->slugify($newGroup->getName()));
        $this->em->persist($newGroup);
        $this->em->flush();
        return $this->json(['idGroup'=>$newGroup->getId()],200);
    }

    #[Route('/editer', name: 'edit')]
    public function groupEdit(Request $request): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $nameGroup = $data['group'];
        $group = $this->groupTomeRepository->findOneBy(['id'=>$data['idGroup']]);
        if (!$group) {
            return $this->json(['message'=>'Impossible de trouver se groupe'],400);
        }
        $groupExist = $this->groupTomeRepository->findBy(['name'=>$nameGroup,'collectionLibrary'=>$group->getCollectionLibrary()]);
        if ($groupExist) {
            return $this->json(['message'=>'Ce groupe existe déjà pour cette collection'], 400);
        }
        $slugify = new Slugify();
        $group->setName($nameGroup)->setSlug($slugify->slugify($group->getName()));
        $this->em->persist($group);
        $this->em->flush();
        return $this->json([],200);
    }

    #[Route('/ajout/tome', name: 'add_tome_group')]
    public function tomeAddGroup(Request $request): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $nameTome = $data['nameNewTomeGroup'];
        if ($nameTome == "") {
            return $this->json(['message'=>'Une erreur c\'est produit'], 400);
        }
        $collection = $this->collectionRepository->findOneBy(['id'=>$data['collection']]);
        $group = $this->groupTomeRepository->findOneBy(['id'=>$data['group']]);
        $tomeExist = $this->tomeRepository->findBy(['name'=>$nameTome,'collectionLibrary'=>$collection,'groupTome'=>$group]);
        if ($tomeExist) {
            return $this->json(['message'=>'Ce tome existe déjà pour cette collection'], 400);
        }
        $newTome = new TomeCollection();
        $newTome->setName($nameTome)->setCollectionLibrary($collection);
        $dateNow = new DateTime('now');
        $slugify = new Slugify();
        $newTome->setDateCreate($dateNow)->setDateModifie($dateNow)->setSlug($slugify->slugify($newTome->getName()))->setGroupTome($group);
        $this->em->persist($newTome);
        $collection->setNumberTome($collection->getNumberTome() + 1);
        $this->em->persist($collection);
        $this->em->flush();
        return $this->json(['idTome'=>$newTome->getId()],200);
    }

    #[Route('/{idCollection}/supprimer/{idGroup}', name: 'delete')]
    public function groupDelete($idCollection,$idGroup): Response
    {
        $collection = $this->collectionRepository->findOneBy(['id'=>$idCollection]);
        $group = $this->groupTomeRepository->findOneBy(['id'=>$idGroup]);
        if (!$group) {
            $this->addFlash('error','Impossible de trouver le groupe sélectionner');
            return $this->redirectToRoute('admin_collection_edit',['slugCategory'=>$collection->getCategoryCollection()->getSlug(),'slugCollection'=>$collection->getSlug()]);
        }
        $this->em->remove($group);
        $this->em->flush();
        $this->addFlash('success','Le groupe à bien était supprimé');
        return $this->redirectToRoute('admin_collection_edit',['slugCategory'=>$collection->getCategoryCollection()->getSlug(),'slugCollection'=>$collection->getSlug()]);
    }
}