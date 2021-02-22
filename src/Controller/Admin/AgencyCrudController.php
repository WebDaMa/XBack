<?php

namespace App\Controller\Admin;

use App\Entity\Agency;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AgencyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Agency::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Agency')
            ->setEntityLabelInPlural('Agency')
            ->setSearchFields(['id', 'code', 'description'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $code = TextField::new('code');
        $description = TextField::new('description');
        $agencyCustomers = AssociationField::new('agencyCustomers');
        $id = IntegerField::new('id', 'ID');
        $agencyGroeps = AssociationField::new('agencyGroeps');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$code, $description, $agencyCustomers];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $code, $description, $agencyCustomers, $agencyGroeps];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$code, $description, $agencyCustomers];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$code, $description, $agencyCustomers];
        }
    }
}
