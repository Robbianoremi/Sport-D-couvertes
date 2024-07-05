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
               
            ])
            ->add('nbrPers', ChoiceType::class, [
                'label' => 'Nombre de personnes',
            
                'choices' => [
                    '1 pers' => 1,
                    '2 pers' => 2,
                    '3 pers' => 3,
                    '4 pers' => 4,
                    '5 pers' => 5,
                    '6 pers' => 6,
                    '7 pers' => 7,
                    '8 pers' => 8,
                    '9 pers' => 9,
                    '10 pers' => 10,
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
