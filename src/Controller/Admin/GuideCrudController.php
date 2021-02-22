<?php

namespace App\Controller\Admin;

use App\Entity\Guide;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GuideCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Guide::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Guide')
            ->setEntityLabelInPlural('Guide')
            ->setSearchFields(['id', 'guideShort', 'guideFirstName', 'guideLastName'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $guideShort = TextField::new('guideShort');
        $guideFirstName = TextField::new('guideFirstName');
        $guideLastName = TextField::new('guideLastName');
        $plannings = AssociationField::new('plannings');
        $id = IntegerField::new('id', 'ID');
        $planningsCag1 = AssociationField::new('planningsCag1');
        $planningsCag2 = AssociationField::new('planningsCag2');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$guideShort, $guideFirstName, $guideLastName, $plannings];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $guideShort, $guideFirstName, $guideLastName, $plannings, $planningsCag1, $planningsCag2];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$guideShort, $guideFirstName, $guideLastName, $plannings];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$guideShort, $guideFirstName, $guideLastName, $plannings];
        }
    }
}
