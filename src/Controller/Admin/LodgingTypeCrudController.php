<?php

namespace App\Controller\Admin;

use App\Entity\LodgingType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LodgingTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LodgingType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('LodgingType')
            ->setEntityLabelInPlural('LodgingType')
            ->setSearchFields(['id', 'code', 'description'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $code = TextField::new('code');
        $description = TextField::new('description');
        $lodgingCustomers = AssociationField::new('lodgingCustomers');
        $id = IntegerField::new('id', 'ID');
        $agency = AssociationField::new('agency');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$code, $description, $lodgingCustomers];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $code, $description, $lodgingCustomers, $agency];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$code, $description, $lodgingCustomers];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$code, $description, $lodgingCustomers];
        }
    }
}
