<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Vma;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class, [
                'label' => "Mot de passe",
            ])
            ->add('firstname', TextType::class, [
                'label' => "Prenom"
            ])
            ->add('lastname', TextType::class, [
                'label' => "Nom"
            ])
            ->add('city', TextType::class, [
                'label' => "Ville"
            ])
            ->add('dateOfBirth', BirthdayType::class, [
                'label' => 'Date de naissance'
            ])
            ->add('picture', UrlType::class, [
                'label' => 'Photo de profil'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
