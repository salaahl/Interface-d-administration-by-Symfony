<?php

namespace App\Form;

use App\Entity\FitnesspPartenaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque')
            ->add('nom')
            ->add('mail')
            ->add('mot_de_passe')
            ->add('niveau_droits')
            ->add('premiere_connexion')
            ->add('nombre_de_structures')
            ->add('perm_boissons')
            ->add('perm_planning')
            ->add('perm_newsletter')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FitnesspPartenaire::class,
        ]);
    }
}