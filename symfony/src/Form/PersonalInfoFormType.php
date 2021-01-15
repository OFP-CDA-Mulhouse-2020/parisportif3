<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PersonalInfoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'required' => true,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Veuillez entrer un Email.'
                            ]
                        )
                    ]
                ]
            )
            ->add(
                'lastName',
                TextType::class,
                [
                    'required' => true,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Veuillez entrer votre nom.'
                            ]
                        )
                    ]
                ]
            )
            ->add(
                'firstName',
                TextType::class,
                [
                    'required' => true,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Veuillez entrer votre prénom.'
                            ]
                        )
                    ]
                ]
            )
            ->add(
                'timeZone',
                TimezoneType::class,
                [
                    'required' => true,
                    'constraints' =>
                        new NotBlank(
                            [
                                'message' => "Veuillez indiquer votre TimeZone"
                            ]
                        )
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}
