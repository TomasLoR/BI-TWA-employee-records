<?php

namespace App\Form;

use App\Entity\Role;
use App\Repository\EmployeeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;



class RoleType extends AbstractType
{
    public function __construct()
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', Type\TextType::class, [
                'label' => 'Jméno',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Např. Software Developer'
                ],
            ])
            ->add('description', Type\TextareaType::class, [
                'label' => 'Popis',
                'required' => false,
            ])
            ->add('isVisible', Type\ChoiceType::class, [
                'label' => 'Viditelnost',
                'choices' => [
                    'Viditelná' => true,
                    'Neviditelná' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Role::class,
        ]);
    }
}
