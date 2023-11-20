<?php

namespace App\Controller;

use App\Form\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CollectionLibraryRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryCollectionRepository;
use App\Services\GestionSearchReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ViewCategoryController extends AbstractController
{
    private $categoryRepository;
    private $collectionRepository;
    private $params;
    public function __construct(CategoryCollectionRepository $categoryCollectionRepository,CollectionLibraryRepository $collectionLibraryRepository,ParameterBagInterface $params){
        $this->categoryRepository = $categoryCollectionRepository;
        $this->collectionRepository = $collectionLibraryRepository;
        $this->params = $params;
    } 

    #[Route('/category/{slugCategory}/{start}', name: 'category')]
    public function categoryView(Request $request,GestionSearchReturn $gestionSearchReturn,$slugCategory,$start = 0): Response
    {
        $category = $this->categoryRepository->findOneBy(['slug'=>$slugCategory]);
        if (!$category) {
            $this->addFlash('error','Impossible de trouver la catégorie sélectionner');
            return $this->redirectToRoute('home');
        }
        $collections = $this->collectionRepository->findBy(['categoryCollection'=>$category],['name'=>'ASC'],$this->params->get('limit_pagination'),$start);
        if (count($collections) == 0 ) { return $this->redirectToRoute('category',['slugCategory'=>$slugCategory]); }
        $nextCollections = $this->collectionRepository->findBy(['categoryCollection'=>$category],['name'=>'ASC'],1,$start + $this->params->get('limit_pagination'));
        $numberPaginations =  ceil(count($this->collectionRepository->findBy(['categoryCollection'=>$category])) / $this->params->get('limit_pagination'));
        $searchForm = $this->createForm(SearchType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $data = $gestionSearchReturn->gestionsData($searchForm->getData());
            return $this->redirectToRoute('search_collection',[
                'termSearch' => $data[0],
                'categorySearch' => $data[1],
                'genreSearch' => $data[2],
            ]); 
        }
        return $this->render('frontend/pages/category_view.html.twig',[
            'category'=>$category,
            'collections'=>$collections,
            'nextCollections'=>$nextCollections,
            'searchForm'=>$searchForm->createView(),
            'limit' => $this->params->get('limit_pagination'),
            'start' => $start,
            'numberPaginations' => $numberPaginations,
        ]);
    }
}