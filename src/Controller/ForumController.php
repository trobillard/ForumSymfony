<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Subject;
use App\Form\SubjectType;
use App\Repository\SubjectRepository;


class ForumController extends AbstractController
{
    #[Route('/forum', name: 'forum')]
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $subjectRepository = $this->getDoctrine()->getRepository(Subject::class);
        $subjects = $subjectRepository->findAll();

        return $this->render('forum/index.html.twig', [
            'subjects' => $subjects,
        ]);
    }

    #[Route('/forum/rules', name: 'rules')]
    public function rules(): Response
    {
        return $this->render('forum/rules.html.twig', [
        ]);
    }

    #[Route('/forum/abtSymfony', name: 'abtSymfony')]
    public function abtSymfony(): Response
    {
        return $this->render('forum/abtSymfony.html.twig', [
        ]);
    }

    #[Route('/forum/subject/new', name: 'newSubject')]
    public function newSubject(Request $request): Response
    {   
        // creation de l objet vide (objet a hydrater)
        $subject = new Subject();
        // creation de l objet formulaire sur la base de la classe SubjectType et tu vas hydrater l objet sur la var $subject
        $form = $this->createForm(SubjectType::class, $subject);
        // dire au formulaire de traiter la requete (representer par $request) injecter dans new Subject parametre $request
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $subject->setPublished(new \DateTime()); 
            // instancier la date et l heure du jour new \DateTime permet d implementer DateTimeInterface donc de ne pas rentrer la valeur dans le form et de l'obtenir
            // le \ permet de dire d'aller chercher DateTime a la racine 
            $entityManager = $this->getDoctrine()->getManager();
            // je vais chercher l entityManager , le manager de doctrine que j enregistre dans une variable
            $entityManager->persist($subject);
            // persist prepare l enregistrement en bdd
            $entityManager->flush();
            // le flush permet l enregistrement en bdd / le flush fait un commit pour valider
            return $this->redirectToRoute('index');
        }
        return $this->render('forum/newSubject.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/forum/subject/{id}', name: 'single', requirements: ["id"=>"\d+"])]
    // "\d+" regex pour dire id d+
    public function single(int $id=3, SubjectRepository $subjectRepository): Response
    // $id=1 est fait pour avoir un parametre par defaut et afficher le post id=1 
    // SubjectRepository $subjectRepository (injection de service) possible seulement car on a charger la classe dans le controller
    {
        $subject = $subjectRepository->find($id);
        // find est une methode du repository qui va chercher par defaut la clef primaire
        return $this->render('forum/single.html.twig', [
            "subject" => $subject
        ]);
    }
}
