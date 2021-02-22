<?php

namespace App\Controller\Admin;

use App\Entity\Activity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ActivityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Activity::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Activity')
            ->setEntityLabelInPlural('Activity')
            ->setSearchFields(['price', 'id', 'name'])
            ->setPaginatorPageSize(200);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $programActivities = AssociationField::new('programActivities');
        $agency = AssociationField::new('agency');
        $activityGroup = AssociationField::new('activityGroup');
        $price = NumberField::new('price');
        $customers = AssociationField::new('customers');
        $location = AssociationField::new('location');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $programActivities, $agency, $activityGroup, $customers, $location, $price];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$price, $id, $name, $programActivities, $agency, $activityGroup, $customers, $location];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $programActivities, $agency, $activityGroup, $price, $customers, $location];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $programActivities, $agency, $activityGroup, $price, $customers, $location];
        }
    }
}
