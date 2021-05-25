<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom')
        ->add('prenom')
        ->add('adresse')
        ->add('ville')
        ->add('code_postal')        
        ->add('telephone')
        ->add('email', EmailType::class,[
            "label"=>"Votre E-mail",
            "attr"=>[
                "class"=>"form-control"
            ],
            "help"=>"Votre email vous sert à vous connecter à cotre compte."
        ])

        ->add('password', PasswordType::class, [
            "label"=>"Votre mot de passe",
            "attr"=>[
                "class"=>"form-control"
            ]
        ]);

        
        // ->add('roles', ChoiceType::class,[
        //     "choices"=>[
        //         "Rôle administrateur"=>"ROLE_ADMIN",
        //         "Rôle utilisateur"=>"ROLE_USER"
        //     ],
            
        //         "multiple"=>true,
        //         "expanded"=>true
        // ]   );


        if($options["isAdmin"] == true){
            $builder->add('roles', ChoiceType::class, [
                'choices'=>[
                    "Role administrateur"=>"ROLE_ADMIN"],
                    // "Role utilisateur"=>"ROLE_USER"
                    "multiple"=>true,
                    "expanded"=>true
                    
            ]   );
        }     

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isAdmin'=> false
        ]);
    }
}

    // $entityManager->persist($user);
    // $entityManager->flush();
    // return $this->redirectToRoute('front');

    // return $this->render('user/new.html.twig',[
    //     'user'=>$user,
    //     'form'=>$form->createView(),
    // ]);


