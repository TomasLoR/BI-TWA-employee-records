<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Role;
use App\Repository\RoleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class EmployeeType extends AbstractType
{
    public function __construct(private readonly RoleRepository $roleRepository)
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', Type\TextType::class, [
                'label' => 'Jméno',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Např. Jan Novák'
                ],
            ])
            ->add('email', Type\EmailType::class, [
                'label' => 'Email',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Např. example@gmail.com'
                ],
            ])
            ->add('phone', Type\TelType::class, [
                'label' => 'Telefon',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Např. +420 123 456 789'
                ],
            ])
            ->add('website', Type\UrlType::class, [
                'label' => 'Web',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Např. https://www.example.com'
                ],
            ])
            ->add('description', Type\TextareaType::class, [
                'label' => 'Popis',
                'required' => false,
            ])
            ->add('joinedAt', Type\DateType::class, [
                'label' => 'Evidován dne',
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('photoUrl', Type\TextType::class, [
                'label' => 'URL vaší fotky',
                'help' => 'Zatím pouze "photos/male.png" nebo "photos/female.png"',
                'required' => false,
            ])
            ->add('roles', EntityType::class, [
                'class' => Role::class,
                'choice_label' => 'name',
                'label' => 'Role',
                'multiple' => true,
                'expanded' => $this->roleRepository->count() <= 5,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
