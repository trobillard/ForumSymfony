<?php

namespace App\Form;

use App\Entity\Subject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SubjectType extends AbstractType
{
    // methode qui construit le formulaire
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // fonction qui construit le formulaire
        $builder
            ->add('title')
            // pour changer le nom : ->add('title'), null, "label" => "Titre"])
            ->add('content')
            // ->add('published') retirer pour ne pas a avoir cette option dans le form
            ->add('Send', SubmitType::class, [
                "attr" => ["class" => "btn text-white"],
                'row_attr' => ['class' =>'text-center']
            ])
            // champs representer par un objet de classe submittype
            // attr => ["class" =>""] permet de creer une classe et de la gerer en css]
            // 'row_attr' => ['class' =>'text-center'] permet de modifier la div avant le button!
        ;
    }
    // Methode qui configure le formulaire
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Subject::class,
        ]);
    }
}
// le formulaire est relier a la classe sujet donc il doit hydrater la Classe Subject