<?php

namespace App\Services;

use App\Repository\CollectionLibraryRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GestionSearchReturn{

    private $collectionRepository;
    private $params;
    public function __construct(CollectionLibraryRepository $collectionLibraryRepository,ParameterBagInterface $params){
        $this->collectionRepository = $collectionLibraryRepository;
        $this->params = $params;
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

    public function searchResult($termSearch,$categorySearch,$genreSearch,$start,$verif = null,$total = true){
        if ($termSearch == "toute-collection") {
            $termSearch = "";
        }

        $queryBuilder = $this->collectionRepository->createQueryBuilder('co')
            ->Where('co.name LIKE :name')
            ->setParameter('name', '%'.$termSearch.'%');
           
        if ($verif) {
            $queryBuilder->setFirstResult($this->params->get('limit_pagination') + $start)
            ->setMaxResults($this->params->get('limit_pagination'));
        }elseif ($total != true) {
            $queryBuilder->setFirstResult($start)->setMaxResults($this->params->get('limit_pagination'));
        }

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