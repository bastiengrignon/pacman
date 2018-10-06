<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PacManController extends AbstractController
{
    /**
     * @Route("/pacman", name="pacman")
     */
    public function index(Request $request, ObjectManager $manager, User $user = null)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('pacman');
        }

        return $this->render('pac_man/index.html.twig',[
            'formUser' => $form->createView()
        ]);
    }

    /**
     * @Route("/pacman/edit", name="edit_pacman")
     * @param Request $request
     * @param ObjectManager $manager
     * @param User|null $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, ObjectManager $manager, User $user = null)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('pacman');
        }

        return $this->render('pac_man/edit.html.twig',[
            'formUser' => $form->createView()
        ]);
    }

    /**
     * @Route("/", name="home")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home() {
        return $this->render('pac_man/home.html.twig');
    }

}
