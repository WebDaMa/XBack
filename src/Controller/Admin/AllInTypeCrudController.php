<?php

namespace App\Controller\Admin;

use App\Entity\AllInType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AllInTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AllInType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('AllInType')
            ->setEntityLabelInPlural('AllInType')
            ->setSearchFields(['price', 'id', 'code', 'description'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $code = TextField::new('code');
        $description = TextField::new('description');
        $price = NumberField::new('price');
        $allCustomers = AssociationField::new('allCustomers');
        $id = IntegerField::new('id', 'ID');
        $agency = AssociationField::new('agency');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$code, $description, $price, $allCustomers];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$price, $id, $code, $description, $allCustomers, $agency];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$code, $description, $price, $allCustomers];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$code, $description, $price, $allCustomers];
        }
    }
}
