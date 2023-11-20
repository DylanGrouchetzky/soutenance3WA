<?php

namespace App\Twig;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use App\Repository\CategoryCollectionRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AdminExtension extends AbstractExtension
{

    public function getFunctions()
    {
        return [
            new TwigFunction('getCategoryList', [$this, 'getCategoryList']),
            new TwigFunction('fileExists', [$this, 'fileExists']),
        ];
    }

    private $categoryRepository;
    private $params;
    public function __construct(CategoryCollectionRepository $categoryCollectionRepository,ParameterBagInterface $params){
        $this->categoryRepository = $categoryCollectionRepository;
        $this->params = $params;
    }

    public function getCategoryList(){
        $categories = $this->categoryRepository->findAll();
        return $categories;
    }

    public function fileExists($file){
        return file_exists($this->params->get('upload_directory').'/'.$file);
    }
}