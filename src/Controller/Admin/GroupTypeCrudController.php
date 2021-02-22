<?php

namespace App\Controller\Admin;

use App\Entity\GroupType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GroupTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GroupType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('GroupType')
            ->setEntityLabelInPlural('GroupType')
            ->setSearchFields(['id', 'code', 'description'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $code = TextField::new('code');
        $description = TextField::new('description');
        $agency = AssociationField::new('agency');
        $customers = AssociationField::new('customers');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$code, $description, $agency, $customers];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $code, $description, $customers, $agency];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$code, $description, $agency, $customers];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$code, $description, $agency, $customers];
        }
    }
}
