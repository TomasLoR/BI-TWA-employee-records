<?php

namespace App\Form;

use App\Entity\Account;
use App\Entity\Employee;
use App\Entity\EnumType;
use App\Repository\EmployeeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function __construct(private readonly EmployeeRepository $employeeRepository)
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', TextType::class, [
                'label' => 'Název',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Např. Přístup k interní síti - Jan Novák'
                ],
            ])
            ->add('password', Type\PasswordType::class, [
                'label' => 'Heslo',
                'help' => 'Heslo musí obsahovat alespoň 8 znaků, jedno velké písmeno a jedno číslo.',
                'required' => true,
            ])
            ->add('type', Type\EnumType::class, [
                'class' => EnumType::class,
                'label' => 'Typ',
                'choice_label' => fn(EnumType $enum) => $enum->getLabel(),
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('expiration', Type\DateType::class, [
                'label' => 'Expirace',
                'widget' => 'single_text',
                'required' => false,
            ])
            // Tento field bych nedával přístupný běžným uživatelům/zaměstancům
            // Vetsi smysl by mi dávál na stránce přehledu všech účtů všech uživatelů
            /*
            ->add('employees', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'name',
                'label' => 'Vlastník účtu',
                'multiple' => false,
                'expanded' => $this->employeeRepository->count() <= 5,
                'placeholder' => 'Žádný',
                'required' => false,
            ])
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
        ]);
    }
}
