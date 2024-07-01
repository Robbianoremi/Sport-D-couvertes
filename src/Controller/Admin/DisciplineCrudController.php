<?php

namespace App\Controller\Admin;

use App\Entity\Discipline;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DisciplineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Discipline::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('nom'),
            TextareaField::new('detail'),
           
        ];
    }
    
}
