<?php

namespace App\Controller;

use App\Form\ParameterWebsiteType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParameterWebsiteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/gestion-super-collect/parametre', name: 'admin_parameter_')]
class AdminParameterWebsiteController extends AbstractController
{
    private $parameterWebsite;
    private $em;

    public function __construct(ParameterWebsiteRepository $parameterWebsite,EntityManagerInterface $em)
    {
        $this->parameterWebsite = $parameterWebsite;
        $this->em = $em;
    }

    #[Route('/', name: 'list')]
    public function index(Request $request,ParameterBagInterface $params): Response
    {
        $parameter = $this->parameterWebsite->findOneBy(['id'=>1]);
        $nameOriginImgHeroSectionHome = $parameter->getImgHeroSectionHome();
        $nameOriginLogoWebsite = $parameter->getLogoWebsite();
        $formParameter = $this->createForm(ParameterWebsiteType::class,$parameter,['imgHeroSectionHome'=>$nameOriginImgHeroSectionHome,'logoWebsite'=>$nameOriginLogoWebsite]); 
        $formParameter->handleRequest($request);
        if ($formParameter->isSubmitted() && $formParameter->isValid()) {
            
            if ($formParameter['imgHeroSectionHome']->getData() != $nameOriginImgHeroSectionHome) {
                $imgHeroSectionHome = $formParameter['imgHeroSectionHome']->getData();
                $filename = uniqid().'.'.$imgHeroSectionHome->guessExtension();
                $imgHeroSectionHome->move($params->get('upload_directory'), $filename);
                $parameter->setImgHeroSectionHome($filename);
            }

            if ($formParameter['logoWebsite']->getData() != $nameOriginLogoWebsite) {
                $logoWebsite = $formParameter['logoWebsite']->getData();
                $filename = uniqid().'.'.$logoWebsite->guessExtension();
                $logoWebsite->move($params->get('upload_directory'), $filename);
                $parameter->setLogoWebsite($filename);
            }
            $parameter = $formParameter->getData();
            $this->em->persist($parameter);
            $this->em->flush();
            $this->addFlash('success','Les informations de votre site à bien était mis à jour');
            return $this->redirectToRoute('admin_parameter_list');
        }
        return $this->render('admin/pages/parameterWebsite/list.html.twig',[
            'form' => $formParameter->createView(),
            'parameterWebsite' => $parameter,
        ]);
    }
}
