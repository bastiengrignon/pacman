<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PacManController extends AbstractController
{
    /**
     * @Route("/pacman", name="pacman")
     */
    public function index(UserRepository $repo)
    {
       $user = $repo->find(2);

        return $this->render('pac_man/index.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/pacman/modify", name="modify")
     * @param Request $request
     * @param ObjectManager $manager
     * @param User|null $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, ObjectManager $manager, User $user = null)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('pacman');
        }

        return $this->render('pac_man/index.html.twig',[
            'formUser' => $form->createView()
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="home")
     */
    public function home() {
        return $this->render('pac_man/home.html.twig');
    }

}
