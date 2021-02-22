<?php

namespace App\Controller\Admin;

use App\Entity\ProgramType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProgramTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProgramType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('ProgramType')
            ->setEntityLabelInPlural('ProgramType')
            ->setSearchFields(['id', 'code', 'description'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $code = TextField::new('code');
        $description = TextField::new('description');
        $programCustomers = AssociationField::new('programCustomers');
        $id = IntegerField::new('id', 'ID');
        $activityProgramTypes = AssociationField::new('activityProgramTypes');
        $agency = AssociationField::new('agency');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$code, $description, $programCustomers];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $code, $description, $activityProgramTypes, $programCustomers, $agency];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$code, $description, $programCustomers];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$code, $description, $programCustomers];
        }
    }
}
