<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
           
            IdField::new('idprofile', 'Identifiant utilisateur'),
            IdField::new('iddiscipline','Activité'),
            TextField::new('nom', 'Nom'),
            DateTimeField::new('bookAt', 'Date'),
        ];
    }
    
}
