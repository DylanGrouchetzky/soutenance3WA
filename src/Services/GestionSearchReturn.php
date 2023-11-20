<?php

namespace App\Services;

use App\Repository\CollectionLibraryRepository;

class GestionSearchReturn{

    private $collectionRepository;
    public function __construct(CollectionLibraryRepository $collectionLibraryRepository){
        $this->collectionRepository = $collectionLibraryRepository;
    }

    public function gestionsData($dataForm){
        $dataSearch = $dataForm;
        $termSearch = $dataSearch['nameCollection'];
        $categorySearch = $dataSearch['category'];
        $genreSearch = $dataSearch['genreCollection'];
        if ($termSearch == null) { $termSearch = "toute-collection"; }
        if ($categorySearch != null) {
            $categorySearch = $categorySearch->getId();
        }else{
            $categorySearch = "tout";
        }
        if ($genreSearch != null) {
            $genreSearch = $genreSearch->getId();
        }else{
            $genreSearch = "tout";
        }
        $data = [$termSearch,$categorySearch,$genreSearch];
        return $data;
    }

    public function searchResult($termSearch,$categorySearch,$genreSearch){
        if ($termSearch == "toute-collection") {
            $termSearch = "";
        }

        $queryBuilder = $this->collectionRepository->createQueryBuilder('co')
            ->Where('co.name LIKE :name')
            ->setParameter('name', '%'.$termSearch.'%');

        if ($categorySearch != "tout" ) {
            $queryBuilder
            ->andWhere('co.categoryCollection = :categoryCollection')
            ->setParameter('categoryCollection', $categorySearch);
        }

        if ($genreSearch != "tout" ) {
            $queryBuilder
            ->leftJoin('co.genreCollection','g')
            ->andWhere('g.id = :genreCollection')
            ->setParameter('genreCollection', $genreSearch);
        }
        
        return $queryBuilder->getQuery()->getResult();
    }
}