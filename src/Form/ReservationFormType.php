<?php

namespace App\Form;

use App\Entity\Discipline;
use App\Entity\Profile;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bookAt', null, [
                'widget' => 'single_text',
                'label' => 'Date et Heure',
            ])
            ->add('idDiscipline', EntityType::class, [
                'class' => Discipline::class,
                'label' => 'Activité',
'choice_label' => 'nom'
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
