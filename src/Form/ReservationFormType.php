<?php

namespace App\Form;

use App\Entity\Discipline;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bookAt', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
            ])
            ->add('idDiscipline', EntityType::class, [
                'class' => Discipline::class,
                'label' => 'Activité',
                'choice_label' => 'nom',
                'placeholder' => 'Choisissez une activité',
                'required' => false,
                'choice_attr' => function ($choice, $key, $value) {
        return ['data-prix' => $choice->getPrix()];
    },
               
            ])
            ->add('nbrPers', ChoiceType::class, [
                'label' => 'Nombre de personnes',
            
                'choices' => [
                    '1 ' => 1,
                    '2 ' => 2,
                    '3 ' => 3,
                    '4 ' => 4,
                    '5 ' => 5,
                    '6 ' => 6,
                    '7 ' => 7,
                    '8 ' => 8,
                    '9 ' => 9,
                    '10 ' => 10,
                ],
                'placeholder' => 'Choisissez le nombre de personnes',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix (€)',
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => true,
                ],
                'mapped' => false, // ce champ n'est pas mappé à l'entité
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
