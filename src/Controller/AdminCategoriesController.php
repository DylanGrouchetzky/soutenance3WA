<?php

namespace App\Controller;

use App\Entity\CategoryCollection;
use App\Form\CategoryType;
use App\Repository\CategoryCollectionRepository;
use Cocur\Slugify\Slugify;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gestion-super-collect/category', name: 'admin_category_')]
class AdminCategoriesController extends AbstractController
{
    private $categoryRepository;
    private $em;
    private $params;

    public function __construct(CategoryCollectionRepository $categoryCollectionRepository, EntityManagerInterface $em,ParameterBagInterface $params)
    {
        $this->categoryRepository = $categoryCollectionRepository;
        $this->em = $em;
        $this->params = $params;
    }

    #[Route('/liste', name: 'list')]
    public function categoryView(): Response
    {
        $categories = $this->categoryRepository->findAll();
        return $this->render('admin/pages/category/list.html.twig',[
            'categories' => $categories,
        ]);
    }

    #[Route('/ajout', name: 'add')]
    public function categoryAdd(Request $request): Response
    {
        $newCategory = new CategoryCollection();
        $categoryForm = $this->createForm(CategoryType::class, $newCategory,['picture'=>'vide']);
        $categoryForm->handleRequest($request);
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $slugify = new Slugify();
            $date = new DateTime('now');
            $newCategory = $categoryForm->getData();
            $categoryExist = $this->categoryRepository->findBy(['name'=>$newCategory->getName()]);
            if ($categoryExist) {
                $this->addFlash('error','Cette catégorie existe déjà');
                return $this->redirectToRoute('admin_category_list');
            }
            if ($categoryForm['picture']->getData() != 'vide') {
                $img = $categoryForm['picture']->getData();
                $filename = uniqid().'.'.$img->guessExtension();
                $img->move($this->params->get('upload_directory'), $filename);
                $newCategory->setPicture($filename);
            }
            $newCategory->setSlug($slugify->slugify($newCategory->getName()))->setDateCreate($date)->setDateModifie($date);
            $this->addFlash('success', 'La catégorie à bien était ajouté');
            $this->em->persist($newCategory);
            $this->em->flush();
            return $this->redirectToRoute('admin_category_list');      
        }
        return $this->render('admin/pages/category/add.html.twig',[
            'formCategory' => $categoryForm->createView(),
        ]);
    }

    #[Route('/editer/{slugCategory}', name: 'edit')]
    public function categoryEdit(Request $request, $slugCategory): Response
    {
        $category = $this->categoryRepository->findOneBy(['slug'=>$slugCategory]);
        if (!$category) {
            $this->addFlash('error','Impossible de trouver la catégorie sélectionner');
            return $this->redirectToRoute('admin_category_list');
        }
        $nameOriginPicture = $category->getPicture();
        $categoryForm = $this->createForm(CategoryType::class, $category,['picture'=>$category->getPicture()]);
        $categoryForm->handleRequest($request);
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $date = new DateTime('now');
            $slugify = new Slugify();
            $category = $categoryForm->getData();
            $categoryExist = $this->categoryRepository->findOneBy(['name'=>$category->getName()]);
            if ($categoryExist && $categoryExist->getId() != $category->getId()) {
                $this->addFlash('error','Cette catégorie existe déjà');
                return $this->redirectToRoute('admin_category_list');
            }
            
            if ($categoryForm['picture']->getData() != $nameOriginPicture) {
                $img = $categoryForm['picture']->getData();
                $filename = uniqid().'.'.$img->guessExtension();
                $img->move($this->params->get('upload_directory'), $filename);
                $category->setPicture($filename);
            }

            $category->setDateModifie($date)->setSlug($slugify->slugify($category->getName()));
            $this->addFlash('success', 'La catégorie à bien était modifié');
            $this->em->flush();
            return $this->redirectToRoute('admin_category_edit',['slugCategory'=>$category->getSlug()]);      
        }
        return $this->render('admin/pages/category/edit.html.twig',[
            'formCategory' => $categoryForm->createView(),
            'category' => $category,
        ]);
    }

    #[Route('/supprimer/{slugCategory}', name: 'delete')]
    public function categoryDelete($slugCategory): Response
    {
        $category = $this->categoryRepository->findOneBy(['slug'=>$slugCategory]);
        if (!$category) {
            $this->addFlash('error','Impossible de trouver la catégorie sélectionner');
            return $this->redirectToRoute('admin_category_list');
        }
        $this->em->remove($category);
        $this->em->flush();
        $this->addFlash('success','La catégorie à bien était supprimé');
        return $this->redirectToRoute('admin_category_list');
    }
}