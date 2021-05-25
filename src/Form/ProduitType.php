<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie')
            // ->add('categorie', ChoiceType::class,["choices"=>[
            //     "Poupées et peluches"=>"Poupées et peluches",
            //     "Jeux de société et puzzles"=>"Jeux de société et puzzles",
            //     "Jeux en plein air et sport"=>"Jeux en plein air et sport",
            //     "Appareils télécommandées"=>"Appareils télécommandées",
            //     "Jeux de construction"=>"Jeux de construction",
            //     "Déguisements"=>"Déguisements",
            //     "Voitures et figurines"=>"Voitures et figurines",
            //     "Musics et multimédia"=>"Musics et multimédia",
            //     "Jeux première âge"=>"Jeux première âge",
            //     "Loisirs et créatifs"=>"Loisirs et créatifs",
            //     "Jeux d'imitation"=>"Jeux d'imitation"]],
            //     ["attr"=>["class"=>"form-control"]]
            // )
            ->add('nom')
            ->add('description')  

            // ->add("tranche d'age") 

            ->add('photoFile', VichImageType::class)
            ->add('telephone')
            ->add('email')
            ->add('etat', ChoiceType::class,["choices"=>[
                "Neuf"=>"Neuf",
                "Trés bon etat"=>"Tres bon etat",
                "Bon état"=>"Bon etat",
                "Etat moyen"=>"Etat moyen",]],
                ["attr"=>["class"=>"form-control"]]
            )
            ->add('transaction', ChoiceType::class,["choices"=>[
                "Troc"=>"Troc",
                // "Vendre"=>"Vendre",
                "A donner"=>"A donner"]],
                ["attr"=>["class"=>"form-control"]])           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
