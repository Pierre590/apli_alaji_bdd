<?php

namespace App\Controller;
use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function quiz()
    {
        $quiz = $this->getDoctrine()
        ->getRepository(Quiz::class)
        ->findAll();


        return $this->render('home/index.html.twig', [
            'quiz' => $quiz,
        ]);
    }
    /**
     * @Route("/{id}", name="home")
     */
    public function test($id)
    {
        $quiz = $this->getDoctrine()
        ->getRepository(Quiz::class)
        ->find($id);


        return $this->render('home/index.html.twig', [
            'one' => $one,
        ]);
    }

}
