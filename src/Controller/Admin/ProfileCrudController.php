<?php

namespace App\Controller\Admin;


use App\Entity\Profile;
use App\Controller\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProfileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Profile::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('idUser', 'Email de l\'utilisateur')
                ->formatValue(function ($value, $entity) {
                    return $entity->getIdUser()->getEmail();
                }),
           
            TextField::new('nom', 'Nom'),
            TextField::new('prenom', 'Prenom'),
            TextField::new('sexe', 'Sexe'),
            TextEditorField::new('bio', 'Biographie'),
            DateTimeField::new('updatedAt', 'Créé le'),

            ImageField::new('imageFile', 'Photo de profil')
                ->setBasePath('/images/photos')
                ->setUploadDir('public/images/photos')
                ->onlyOnIndex(),
                VichImageField::new('imageFile', 'Image')
                ->setTemplatePath('admin/field/vich_image_widget.html.twig')
                ->hideOnIndex(),
        ];
    }
    
}
