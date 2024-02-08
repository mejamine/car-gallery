<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Car;
use App\Entity\Marque;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;

class CarController extends AbstractController
{
    #[Route('/cars/{id}', name: 'cars')]
    public function cars($id)
    {
        $marque = $this->getDoctrine()
        ->getRepository(Marque::class)
        ->find($id);
        $em=$this->getDoctrine()->getManager();
        $cars=$em->getRepository(Car::class)
        ->findBy(['marque'=>$marque]);
        return $this->render('car/index.html.twig', [
            'cars' => $cars,
        ]);
    }
   
}
