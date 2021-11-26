<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Livre;
use App\Form\LivreType;
use Doctrine\ORM\EntityManagerInterface;

class MediathequeController extends AbstractController
{
    /**
     * @Route("/mediatheque", name="mediatheque")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Livre::class);

        $livre = $repo->findAll();

        return $this->render('mediatheque/index.html.twig', [
            'controller_name' => 'MediathequeController',
            'livres' => $livre
        ]);
    }

    /**
     * @Route("/", name="home")
     */

    public function home(){
        return $this->render('mediatheque/home.html.twig');
    }

    /**
     * @Route("/mediatheque/new", name="mediatheque_create")
     * @Route("/mediatheque/{id}/edit", name="mediatheque_edit")
     */
    public function form(Livre $livre = null, Request $request, EntityManagerInterface $manager){

        if(!$livre){
           $livre = new Livre();
        }
            //$form = $this->createFormBuilder($livre)
            //    ->add('title')
            //    ->add('image')
            //    ->add('description', TextareaType::class)
            //    ->add('author')
            //    ->add('release_date', DateType::class, [
            //        'widget' => 'single_text',
            //        // this is actually the default format for single_text
            //        'format' => 'yyyy',
            //        'html5' => false
            //    ])
            //    ->getForm();

       $form = $this->createForm(LivreType::class, $livre);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                if($livre->getId());

                $manager->persist($livre);
                $manager->flush();

                return $this->redirectToRoute('livre_show', ['id' =>$livre->getId()]);
            }

        return $this->render('mediatheque/create.html.twig',[
            'formLivre' => $form->createView(),
            'editMode' => $livre->getId() !==null
        ]);
    }

    /**
     * @Route("/mediatheque/{id}", name="livre_show")
     */
    public function show($id){

        $repo = $this->getDoctrine()->getRepository(Livre::class);

        $livre = $repo->find($id);

        return $this->render('mediatheque/show.html.twig', [
            'livre' => $livre 
        ]);
    }


}

