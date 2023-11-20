<?php

namespace App\Controller;

use DateTime;
use Cocur\Slugify\Slugify;
use App\Entity\CollectionLibrary;
use App\Form\CollectionLibraryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CollectionLibraryRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryCollectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/gestion-super-collect/collection', name: 'admin_collection_')]
class AdminCollectionController extends AbstractController
{
    private $collectionRepository;
    private $categoryRepository;
    private $em;
    private $params;

    public function __construct(CollectionLibraryRepository $collectionLibraryRepository,CategoryCollectionRepository $categoryCollectionRepository,EntityManagerInterface $em,ParameterBagInterface $params)
    {
        $this->collectionRepository = $collectionLibraryRepository;
        $this->categoryRepository = $categoryCollectionRepository;
        $this->em = $em;
        $this->params = $params;
    }

    #[Route('/{slugCategory}', name: 'list')]
    public function categoryView($slugCategory): Response
    {
        $category = $this->categoryRepository->findOneBy(['slug'=>$slugCategory]);
        $collections = $this->collectionRepository->findBy(['categoryCollection'=>$category]);
        return $this->render('admin/pages/collection/list.html.twig',[
            'category' => $category,
            'collections' => $collections,
        ]);
    }

    #[Route('/{slugCategory}/ajout', name: 'add')]
    public function categoryAdd(Request $request, $slugCategory): Response
    {
        $category = $this->categoryRepository->findOneBy(['slug'=>$slugCategory]);
        $newCollection = new CollectionLibrary();
        $collectionForm = $this->createForm(CollectionLibraryType::class, $newCollection,['category_id'=>$category->getId()]);
        $collectionForm->handleRequest($request);
        if ($collectionForm->isSubmitted() && $collectionForm->isValid()) {
            $slugify = new Slugify();
            $date = new DateTime('now');
            $newCollection = $collectionForm->getData();
            $collectionExist = $this->collectionRepository->findOneBy(['name'=>$newCollection->getName(),'categoryCollection'=>$category]);
            if ($collectionExist) {
                $this->addFlash('error','Cette collection existe déjà');
                return $this->redirectToRoute('admin_collection_list',['slugCategory'=>$category->getSlug()]);
            }
            
            if ($collectionForm['picture']->getData() != null ) {
                $img = $collectionForm['picture']->getData();
                $filename = uniqid().'.'.$img->guessExtension();
                $img->move($this->params->get('upload_directory'), $filename);
                $newCollection->setPicture($filename);
            }
            
            if ($collectionForm['bgPicture']->getData() != null ) {
                $bgImg = $collectionForm['bgPicture']->getData();
                $filenameBg = uniqid().'.'.$bgImg->guessExtension();
                $bgImg->move($this->params->get('upload_directory'), $filenameBg);
                $newCollection->setBgPicture($filenameBg);
            }

            $newCollection->setSlug($slugify->slugify($newCollection->getName()))->setDateCreate($date)->setDateModifie($date)->setNumberTome(0)->setCategoryCollection($category);
            $this->addFlash('success', 'La collection à bien était ajouté');
            $this->em->persist($newCollection);
            $this->em->flush();
            return $this->redirectToRoute('admin_collection_edit',['slugCategory'=>$category->getSlug(),'slugCollection'=>$newCollection->getSlug()]);      
        }
        return $this->render('admin/pages/collection/add.html.twig',[
            'category' => $category,
            'collectionForm' => $collectionForm->createView(),
        ]);
    }

    #[Route('/{slugCategory}/editer/{slugCollection}', name: 'edit')]
    public function categoryEdit(Request $request, ParameterBagInterface $params,$slugCategory, $slugCollection): Response
    {
        $category = $this->categoryRepository->findOneBy(['slug'=>$slugCategory]);
        $collection = $this->collectionRepository->findOneBy(['slug'=>$slugCollection,'categoryCollection'=>$category]);
        if (!$collection) {
            $this->addFlash('error','Impossible de trouver la collection sélectionner');
            return $this->redirectToRoute('admin_collection_list',['slugCategory'=>$category->getSlug()]);
        }
        $nameOriginPicture = $collection->getPicture();
        $nameOriginBgPicture = $collection->getBgPicture();
        $collectionForm = $this->createForm(CollectionLibraryType::class, $collection, ['category_id'=>$category->getId(),'picture'=>$nameOriginPicture,'bgPicture'=>$nameOriginBgPicture]);
        $collectionForm->handleRequest($request);
        if ($collectionForm->isSubmitted() && $collectionForm->isValid()) {
            $date = new DateTime('now');
            $collectionExist = $this->collectionRepository->findOneBy(['name'=>$collectionForm['name']->getData(),'categoryCollection'=>$category]);
            if ($collectionExist && $collectionExist->getId() != $collection->getId()) {
                $this->addFlash('error','Cette collection existe déjà');
                return $this->redirectToRoute('admin_collection_edit',['slugCategory'=>$category->getSlug(),'slugCollection'=>$collection->getSlug()]);
            }
            
            if ($collectionForm['picture']->getData() != $nameOriginPicture) {
                $img = $collectionForm['picture']->getData();
                $filename = uniqid().'.'.$img->guessExtension();
                $img->move($params->get('upload_directory'), $filename);
                $collection->setPicture($filename);
            }

            if ($collectionForm['bgPicture']->getData() != $nameOriginBgPicture) {
                $bgImg = $collectionForm['bgPicture']->getData();
                $filenameBg = uniqid().'.'.$bgImg->guessExtension();
                $bgImg->move($params->get('upload_directory'), $filenameBg);
                $collection->setBgPicture($filenameBg);
            }

            $collection = $collectionForm->getData();
            $slugify = new Slugify();
            $collection->setSlug($slugify->slugify($collection->getName()));
            $category->setDateModifie($date);
            $this->addFlash('success', 'La collection à bien était modifié');
            $this->em->flush();
            return $this->redirectToRoute('admin_collection_edit',['slugCategory'=>$category->getSlug(),'slugCollection'=>$collection->getSlug()]);      
        }
        return $this->render('admin/pages/collection/edit.html.twig',[
            'category' => $category,
            'collectionForm' => $collectionForm->createView(),
            'collection' => $collection,
        ]);
    }

    #[Route('/{idCategory}/supprimer/{idCollection}', name: 'delete')]
    public function categoryDelete($idCategory, $idCollection): Response
    {
        $category = $this->categoryRepository->findOneBy(['id'=>$idCategory]);
        $collection = $this->collectionRepository->findOneBy(['id'=>$idCollection]);
        if (!$collection) {
            $this->addFlash('error','Impossible de trouver la collection sélectionner');
            return $this->redirectToRoute('admin_collection_list',['slugCategory'=>$category->getSlug()]);
        }
        $this->em->remove($collection);
        $this->em->flush();
        $this->addFlash('success','La collection à bien était supprimé');
        return $this->redirectToRoute('admin_collection_list',['slugCategory'=>$category->getSlug()]);
    }
}