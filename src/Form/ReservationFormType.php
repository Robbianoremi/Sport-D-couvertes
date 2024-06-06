<?php

namespace App\Form;

use App\Entity\Profile;
use App\Entity\Discipline;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bookAt', null, 
                [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer une date et une heure',
                        ]),
                        new Regex([
                            'pattern' => '/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(?:\.\d+)?(?:Z|[+\-]\d{2}:\d{2})?$/',
                            'message' => 'Le format de la date et de l\'heure est invalide',
                        ]),
                    ],
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
