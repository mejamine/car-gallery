<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Marque;
use App\Entity\Car;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }
    #[Route('/addMarque',name:'addMarque')]
    public function addMarque(Request $request,ParameterBagInterface $parameterBag)
    {
        $marque = new Marque();
        $f = $this->createFormBuilder($marque)
        ->add('name',TextType::class)
        ->add('logo', FileType::class)
        ->add('Submit', SubmitType::class);
        $form= $f->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $directory=$parameterBag->get('upload_directory_marque');
            $file=$form['logo']->getData();
            $file->move($directory, $file->getClientOriginalName());
            $marque->setLogo($file->getClientOriginalName());
            $em=$this->getDoctrine()->getManager();
            $em->persist($marque);
            $em->flush();
            return $this->redirectToRoute('viewMarque');
        }
        return $this->render('admin/addMarque.html.twig',
        ['f' => $form->createView()]);
    }
    #[Route('/addCar',name:'addCar')]
    public function addCar(Request $request,ParameterBagInterface $parameterBag)
    {
        $car = new Car();
        $f = $this->createFormBuilder($car)
        ->add('name',TextType::class)
        ->add('image', FileType::class)
        ->add('description',TextType::class)
        ->add('marque', EntityType::class,[
            'class'=> Marque::class,
            'choice_label' =>'name',
            ])
        ->add('Submit', SubmitType::class);
        $form= $f->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $directory=$parameterBag->get('upload_directory_car');
            $file=$form['image']->getData();
            $file->move($directory, $file->getClientOriginalName());
            $car->setImage($file->getClientOriginalName());
            $em=$this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();
            return $this->redirectToRoute('viewCar');
        }
        return $this->render('admin/addCar.html.twig',
        ['f' => $form->createView()]);
    }
    #[Route('/viewCar',name:'viewCar')]
    public function showCarAdmin()
    {
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository(Car::class);
        $cars=$repo->findAll();
        return $this->render('admin/showCarAdmin.html.twig',[
            'cars' => $cars,
        ]);
    }
    #[Route('/deleteCar/{id}', name:'deleteCar')] 
    public function deleteCar(Request $request,$id):Response{
        $C = $this->getDoctrine()->getRepository(Car::class)->find($id);
        if(!$C){
            throw $this->createNotFoundException('No Car found for id'.$id);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($C);
        $entityManager->flush();
        return $this->redirectToRoute('viewCar');
    }
    #[Route('/editCar/{id}', name:'editCar')] 
    public function editCar(Request $request,$id){
        $car = new Car();
        $car = $this->getDoctrine()
        ->getRepository(Car::class)
        ->find($id);
        if(!$car){
            throw $this->createNotFoundException(
                    'No Car Found For id ' .$id
            );
        }
        $fb = $this->createFormBuilder($car)
        ->add('name', TextType::class)
        ->add('description' , TextType::class)
        ->add('marque', EntityType::class,[
            'class'=> Marque::class,
            'choice_label'=> 'name'
        ])
        ->add('Submit', SubmitType::class);
        $form=$fb->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('viewCar');
        }
        return $this->render('admin/addCar.html.twig',[
            'f' => $form->createView(),
        ]);
    }
    #[Route('/editCarImage/{id}', name:'editCarImage')] 
    public function editCarImage(Request $request,$id){
        $car = new Car();
        $car = $this->getDoctrine()
        ->getRepository(Car::class)
        ->find($id);
        if(!$car){
            throw $this->createNotFoundException(
                    'No Car Found For id ' .$id
            );
        }
        $fb = $this->createFormBuilder($car)
        ->add('image', FileType::class,[
            'data_class'=>null])
        ->add('Submit', SubmitType::class);
        $form=$fb->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $directory=$parameterBag->get('upload_directory_car');
            $file=$form['image']->getData();
            $file->move($directory, $file->getClientOriginalName());
            $car->setImage($file->getClientOriginalName());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('viewCar');
        }
        return $this->render('admin/addCar.html.twig',[
            'f' => $form->createView(),
        ]);
    }
    #[Route('/viewMarque',name:'viewMarque')]
    public function showMarqueAdmin()
    {
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository(Marque::class);
        $marques=$repo->findAll();
        return $this->render('admin/showMarqueAdmin.html.twig',[
            'marques' => $marques,
        ]);
    }
    #[Route('/deleteMarque/{id}', name:'deleteMarque')] 
    public function deleteMarque(Request $request,$id):Response{
        $M = $this->getDoctrine()->getRepository(Marque::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $cars=$em->getRepository(Car::class)
        ->findBy(['marque'=>$M]);
        if(!$M){
            throw $this->createNotFoundException('No Marque found for id'.$id);
        }
        $entityManager = $this->getDoctrine()->getManager();
        foreach ($cars as $car){
            $entityManager->remove($car);
            $entityManager->flush();
        }
        $entityManager->remove($M);
        $entityManager->flush();
        return $this->redirectToRoute('viewMarque');
    }
    #[Route('/editMarque/{id}', name:'editMarque')] 
    public function editMarque(Request $request,$id){
        $marque = new Marque();
        $marque = $this->getDoctrine()
        ->getRepository(Marque::class)
        ->find($id);
        if(!$marque){
            throw $this->createNotFoundException(
                    'No Marque Found For id ' .$id
            );
        }
        $fb = $this->createFormBuilder($marque)
        ->add('name', TextType::class)
        ->add('Submit', SubmitType::class);
        $form=$fb->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('viewMarque');
        }
        return $this->render('admin/addMarque.html.twig',[
            'f' => $form->createView(),
        ]);
    }
    #[Route('/editMarqueImage/{id}', name:'editMarqueImage')] 
    public function editMarqueImage(Request $request,$id){
        $marque = new Marque();
        $marque = $this->getDoctrine()
        ->getRepository(Marque::class)
        ->find($id);
        if(!$marque){
            throw $this->createNotFoundException(
                    'No Marque Found For id ' .$id
            );
        }
        $fb = $this->createFormBuilder($marque)
        ->add('logo', FileType::class,[
            'data_class'=>null])
        ->add('Submit', SubmitType::class);
        $form=$fb->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $directory=$parameterBag->get('upload_directory_marque');
            $file=$form['logo']->getData();
            $file->move($directory, $file->getClientOriginalName());
            $marque->setLogo($file->getClientOriginalName());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('viewMarque');
        }
        return $this->render('admin/addMarque.html.twig',[
            'f' => $form->createView(),
        ]);
    }
}
