<?php

namespace App\Controller;

use App\Entity\Informations;
use App\Entity\User;
use App\Form\InformationsType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PacManController extends AbstractController
{
    /**
     * @Route("/pacman", name="pacman")
     */
    public function index(Request $request, ObjectManager $manager, Informations $info)
    {
        if (!$info) {
            $info = new Informations();
        }
        $form = $this->createForm(InformationsType::class, $info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $manager->persist($info);
            $manager->flush();
        }

        return $this->render('pac_man/index.html.twig', [
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
