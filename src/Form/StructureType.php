<?php

namespace App\Form;

use App\Entity\FitnesspStructure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mail_partenaire')
            ->add('adresse')
            ->add('mail')
            ->add('mot_de_passe')
            ->add('niveau_droits')
            ->add('premiere_connexion')
            ->add('perm_boissons')
            ->add('perm_planning')
            ->add('perm_newsletter')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FitnesspStructure::class,
        ]);
    }
}
