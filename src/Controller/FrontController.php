<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Repository\UserRepository;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{

    #[Route('/espace_abonne', name: 'espace_abonne')]
    public function index(UserRepository $user, ProduitRepository $repoProduit): Response
    {
        $user = $this->getUser();
        $email = $user->getEmail();
      $produit=$repoProduit->findBy( ['email'=> $email]);
      dump($email) ;
        return $this->render('front/espace_abonne.html.twig', [
            'produits' => $produit
            
        ]);
    }

    #[Route('/', name: 'categorie', methods: ['GET'])]
    public function categorie(CategorieRepository $categorieRepository): Response
    {
        return $this->render('front/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/produits/{id}", name="show_produits", methods={"GET"})
     */
    public function produit(ProduitRepository $produitRepository, Categorie $categorie): Response
    {
        return $this->render('front/produit.html.twig', [
                'produits' => $produitRepository->findAll(),
                'categorie'=>$categorie
        ]);
    }

    #[Route('/produit/{id}', name: 'show_produit', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('front/show_produit.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/a_propos_de_nous", name="a_propos_de_nous")
     */
    public function compte(){
        return $this->render('front/a_propos_de_nous.html.twig', [
        ]);
    }

    

    // public function produit_user(UserRepository $user,ProduitRepository $repoProduit){
    //     $user = $this->getUser();
    //     $email = $user->getEmail();
    //   $produit=$repoProduit->findBy( ['email'=> $email]); 
    //   //dump($produit); 

    //   return $this->render('front/espace_abonne.html.twig',[
    //       'produits'=>$produit
    //   ]);
    // }


}
