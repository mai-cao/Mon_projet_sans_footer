<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[Route('/user')]
class UserController extends AbstractController
{

    //la liste des utilisateurs ou des admins est réserver uniquements pour les admins

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user,  ["isAdmin"=>$this->isGranted("ROLE_ADMIN")]);// il faut réserver la création des admins pour les admins
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            //haché le mdp lors de la création d'un nv user(inscription)
            $user->setPassword( $encoder->encodePassword($user, $user->getPassword()));

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        //poser une condtion que seul un admin peut voir les info des users (blog)
        //ou récuperer l'user connecter et seul lui peut voir son compte
        if($this->isGranted("ROLE_ADMIN") || $this->getUser() == $user){
            return $this->render('user/show.html.twig', [
                'user' => $user,
            ]);
        }
        throw $this->createAccessDeniedException();
        
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $encoder): Response
    {

        //verfier si l'utilisateur est admin pour accder a editer ou si l'utlisateur connecter a un statut d'userConnecté il a le droit de modifier son compte

        //L'utilisateur dont on modofie le compte: $user
        //pour récuperer l'utilisateur connecter: $this->getUser();

        if($this->isGranted("ROLE_ADMIN") || $this->getUser() == $user ){
            $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //haché le mdp lors le de modication aussi
            $user->setPassword( $encoder->encodePassword($user, $user->getPassword()));
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('front');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
        }
        throw $this->createAccessDeniedException();
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if($this->isGranted("ROLE_ADMIN") || $this->getUser() == $user){
            if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($user);
                $entityManager->flush();
            }
    
            return $this->redirectToRoute('categorie');
        }
        throw $this->createAccessDeniedException();
    }
}
