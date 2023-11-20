<?php

namespace App\Twig;

use App\Repository\CategoryCollectionRepository;
use App\Repository\CollectionLibraryRepository;
use App\Repository\ParameterWebsiteRepository;
use App\Repository\TomeUserReadRepository;
use App\Repository\TomeUserRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GlobalExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('getCategoryList', [$this, 'getCategoryList']),
            new TwigFunction('getLastCollection', [$this, 'getLastCollection']),
            new TwigFunction('userHasTome', [$this, 'userHasTome']),
            new TwigFunction('userHasTomeRead', [$this, 'userHasTomeRead']),
            new TwigFunction('getNumberTomeUser', [$this, 'getNumberTomeUser']),
            new TwigFunction('getNumberTomeUserRead', [$this, 'getNumberTomeUserRead']),
            new TwigFunction('getPourcentTome', [$this, 'getPourcentTome']),
            new TwigFunction('fileExists', [$this, 'fileExists']),
            new TwigFunction('getParams', [$this, 'getParams']),
            new TwigFunction('getLogo', [$this, 'getLogo']),
            new TwigFunction('getImgHeroSection', [$this, 'getImgHeroSection']),
        ];
    }

    private $categoryRepository;
    private $collectionRepository;
    private $tomeUserRepository;
    private $parameterWebsiteRepository;
    private $tomeUserReadRepository;
    private $params;
    public function __construct(CategoryCollectionRepository $categoryCollectionRepository,CollectionLibraryRepository $collectionLibraryRepository,TomeUserRepository $tomeUserRepository,
    ParameterBagInterface $params,ParameterWebsiteRepository $parameterWebsiteRepository,TomeUserReadRepository $tomeUserReadRepository){
        $this->categoryRepository = $categoryCollectionRepository;
        $this->collectionRepository = $collectionLibraryRepository;
        $this->tomeUserRepository = $tomeUserRepository;
        $this->parameterWebsiteRepository = $parameterWebsiteRepository;
        $this->tomeUserReadRepository = $tomeUserReadRepository;
        $this->params = $params;
    }

    public function getCategoryList(){
        $categories = $this->categoryRepository->findAll();
        return $categories;
    }

    public function getLastCollection($slugCategorie){
        $category = $this->categoryRepository->findOneBy(['slug'=> $slugCategorie]);
        $collections = $this->collectionRepository->findBy(['categoryCollection'=>$category],['id'=>'DESC'],4,0);
        return $collections;
    }

    public function userHasTome($user, $collection, $tome){
        $tomeUser = $this->tomeUserRepository->findOneBy(['user'=>$user,'collectionLibrary'=>$collection,'nameTome'=>$tome]);
        if ($tomeUser) { return true; }
        return false;
    }

    public function userHasTomeRead($user, $collection, $tome){
        $tomeUser = $this->tomeUserReadRepository->findOneBy(['user'=>$user,'collectionLibrary'=>$collection,'nameTome'=>$tome]);
        if ($tomeUser) { return true; }
        return false;
    }

    public function getNumberTomeUser($user, $collection){
        $tomeUser = $this->tomeUserRepository->findBy(['user'=>$user,'collectionLibrary'=>$collection]);
        return count($tomeUser);
    }

    public function getNumberTomeUserRead($user, $collection){
        $tomeUserRead = $this->tomeUserReadRepository->findBy(['user'=>$user,'collectionLibrary'=>$collection]);
        return count($tomeUserRead);
    }

    public function getPourcentTome($numberTomeUser, $numberTomeCollection){
        return 100 / $numberTomeCollection * $numberTomeUser;
    }

    public function fileExists($file){
        return file_exists($this->params->get('upload_directory').'/'.$file);
    }

    public function getParams(){
        return $this->parameterWebsiteRepository->findOneBy(['id'=>1]);
    }

    public function getLogo($file){
        if (file_exists($this->params->get('upload_directory').'/'.$file) and $file != null) {
            
            $imgRoad = 'uploads/'.$file;
        }else{
            $imgRoad = 'img/logo.webp';
        }
        return $imgRoad;
    }

    public function getImgHeroSection($file){
        if (file_exists($this->params->get('upload_directory').'/'.$file) and $file != null) {
            
            $imgRoad = 'uploads/'.$file;
        }else{
            $imgRoad = 'img/banniere.webp';
        }
        return $imgRoad;
    }
}