<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class DeleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('submit', Type\SubmitType::class, [
                'label' => 'Odstranit',
                'attr' => ['class' => 'button',
                    'onclick' => 'return confirm("Opravdu chcete odstranit tento účet? Tato akce je nevratná!");'
                ]

            ])
        ;
    }
}
