<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gestion-super-collect/utilisateur', name: 'admin_user_')]
class AdminUserController extends AbstractController
{
    private $userRepository;
    private $em;

    public function __construct(UserRepository $userRepository,EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    #[Route('/', name: 'list')]
    public function index(): Response
    {
        $users = $this->userRepository->findUsersWithoutAdminRole();
        return $this->render('admin/pages/customer/list.html.twig',['users' => $users]);
    }

    #[Route('/supprimer/{idUser}', name: 'delete')]
    public function deleteUser($idUser): Response
    {
        $user = $this->userRepository->findOneBy(['id'=>$idUser]);
        if (!$user) {
            $this->addFlash('error','L\utilisateur n\'à pas pus être trouvé');
        }else{
            $this->em->remove($user);
            $this->em->flush();
            $this->addFlash('success','L\'utilisateur à bien était supprimé');
        }
        $users = $this->userRepository->findUsersWithoutAdminRole();
        return $this->render('admin/pages/customer/list.html.twig',['users' => $users]);
    }
}
