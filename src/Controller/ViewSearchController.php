<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Services\GestionSearchReturn;
use App\Repository\GenreCollectionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ViewSearchController extends AbstractController
{
    private $genreCollectionRepository;
    private $params;
    public function __construct(GenreCollectionRepository $genreCollectionRepository,ParameterBagInterface $params){
        $this->genreCollectionRepository = $genreCollectionRepository;
        $this->params = $params;
    } 

    #[Route('/afficher/{slugCategory}/{slugGenre}', name: 'search_collection_genre')]
    public function searchTome($slugCategory,$slugGenre): Response
    {
        $genre = $this->genreCollectionRepository->findOneBy(['slug'=>$slugGenre]);
        if (!$genre) {
            return $this->redirectToRoute('category',['slugCategory'=>$slugCategory]);
        }
        return $this->render('frontend/pages/genre_view.html.twig',['genre'=>$genre]);
    }

    #[Route('/recherche/{termSearch}/{categorySearch}/{genreSearch}/{start}', name: 'search_collection')]
    public function searchCollection(Request $request,GestionSearchReturn $gestionSearchReturn,$termSearch,$categorySearch,$genreSearch,$start = 0): Response
    {
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
        $collections = $gestionSearchReturn->searchResult($termSearch,$categorySearch,$genreSearch,$start,null,null);
        $nextCollections = $gestionSearchReturn->searchResult($termSearch,$categorySearch,$genreSearch,$start,true);
        $maxCollections = count($gestionSearchReturn->searchResult($termSearch,$categorySearch,$genreSearch,$start,null));
        $numberPaginations =  ceil($maxCollections / $this->params->get('limit_pagination'));
        return $this->render('frontend/pages/result_search.html.twig',[
            'collections'=>$collections,
            'searchForm' => $searchForm->createView(),
            'nextCollections'=>$nextCollections,
            'limit' => $this->params->get('limit_pagination'),
            'start' => $start,
            'numberPaginations' => $numberPaginations,
            'termSearch' => $termSearch,
            'categorySearch' => $categorySearch,
            'genreSearch' => $genreSearch,
        ]);
    }
}