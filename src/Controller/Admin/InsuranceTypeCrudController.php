<?php

namespace App\Controller\Admin;

use App\Entity\InsuranceType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class InsuranceTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InsuranceType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('InsuranceType')
            ->setEntityLabelInPlural('InsuranceType')
            ->setSearchFields(['insuranceCode', 'insuranceName', 'id', 'code', 'description'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $code = TextField::new('code');
        $description = TextField::new('description');
        $insuranceCode = IntegerField::new('insuranceCode');
        $insuranceName = TextField::new('insuranceName');
        $insCustomers = AssociationField::new('insCustomers');
        $id = IntegerField::new('id', 'ID');
        $agency = AssociationField::new('agency');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$code, $description, $insuranceCode, $insuranceName, $insCustomers];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$insuranceCode, $insuranceName, $id, $code, $description, $insCustomers, $agency];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$code, $description, $insuranceCode, $insuranceName, $insCustomers];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$code, $description, $insuranceCode, $insuranceName, $insCustomers];
        }
    }
}
