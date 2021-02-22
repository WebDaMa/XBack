<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Location')
            ->setEntityLabelInPlural('Location')
            ->setSearchFields(['id', 'code', 'description'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $code = TextField::new('code');
        $description = TextField::new('description');
        $locCustomers = AssociationField::new('locCustomers');
        $id = IntegerField::new('id', 'ID');
        $locGroeps = AssociationField::new('locGroeps');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$code, $description, $locCustomers];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $code, $description, $locCustomers, $locGroeps];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$code, $description, $locCustomers];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$code, $description, $locCustomers];
        }
    }
}
