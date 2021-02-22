<?php

namespace App\Controller\Admin;

use App\Entity\Program;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProgramCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Program::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Program')
            ->setEntityLabelInPlural('Program')
            ->setSearchFields(['days', 'id', 'name'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $agency = AssociationField::new('agency');
        $programGroup = AssociationField::new('programGroup');
        $days = IntegerField::new('days');
        $programType = AssociationField::new('programType');
        $location = AssociationField::new('location');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $agency, $programGroup, $days, $programType, $location];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$days, $id, $name, $agency, $programGroup, $location, $programType];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $agency, $programGroup, $days, $programType, $location];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $agency, $programGroup, $days, $programType, $location];
        }
    }
}
