<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Services\GestionSearchReturn;
use App\Repository\GenreCollectionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ViewSearchController extends AbstractController
{
    private $genreCollectionRepository;
    public function __construct(GenreCollectionRepository $genreCollectionRepository){
        $this->genreCollectionRepository = $genreCollectionRepository;
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

    #[Route('/recherche/{termSearch}/{categorySearch}/{genreSearch}', name: 'search_collection')]
    public function searchCollection(Request $request,GestionSearchReturn $gestionSearchReturn,$termSearch,$categorySearch,$genreSearch): Response
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
        $collections = $gestionSearchReturn->searchResult($termSearch,$categorySearch,$genreSearch);
        return $this->render('frontend/pages/result_search.html.twig',[
            'collections'=>$collections,
            'searchForm' => $searchForm->createView()
        ]);
    }
}