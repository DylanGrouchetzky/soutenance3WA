<?php

namespace App\Controller;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $em): Response
    {
        if ($this->getUser()) {
            $date = new DateTime();
            $user = $this->getUser();
            $user->setLastConnect($date);
            $em->persist($user);
            $em->flush();
        }
        return $this->render('frontend/pages/homepage.html.twig');
    }

    #[Route('/politique-de-confidentialite', name: 'politique_confidentialite')]
    public function politiqueConfidentialite(): Response
    {
        return $this->render('frontend/pages/politique_confidentialite.html.twig');
    }
}