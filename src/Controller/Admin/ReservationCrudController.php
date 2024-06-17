<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('idProfile'),
            AssociationField::new('idDiscipline'),
            DateTimeField::new('createdAt', 'Date du jour'),
            DateTimeField::new('bookAt', 'Date de réservation'),

        ];
    }
}
