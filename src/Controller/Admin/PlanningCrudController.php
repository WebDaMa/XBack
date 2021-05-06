<?php

namespace App\Controller\Admin;

use App\Entity\Planning;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class PlanningCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Planning::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Planning')
            ->setEntityLabelInPlural('Planning')
            ->setSearchFields(['id', 'planningId', 'activity', 'transport', 'guideFunction'])
            ->setPaginatorPageSize(50)
            ->setDefaultSort(['date' => 'DESC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('date')
            ->add(EntityFilter::new('group'))
            ->add(EntityFilter::new('guide'))
            ->add(EntityFilter::new('cag1'))
            ->add(EntityFilter::new('cag2'));
    }

    public function configureFields(string $pageName): iterable
    {
        $planningId = IntegerField::new('planningId');
        $date = DateField::new('date');
        $activity = TextField::new('activity');
        $group = AssociationField::new('group');
        $guide = AssociationField::new('guide');
        $cag1 = AssociationField::new('cag1');
        $cag2 = AssociationField::new('cag2');
        $transport = TextField::new('transport');
        $guideFunction = IntegerField::new('guideFunction');
        $id = IntegerField::new('id', 'ID');
        $createdAt = DateTimeField::new('created_at');
        $modifiedAt = DateTimeField::new('modified_at');
        $createdBy = AssociationField::new('created_by');
        $updatedBy = AssociationField::new('updated_by');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$planningId, $date, $group, $activity, $guide, $cag1, $cag2, $transport, $guideFunction];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $planningId, $date, $activity, $transport, $guideFunction, $createdAt, $modifiedAt, $group, $guide, $cag1, $cag2, $createdBy, $updatedBy];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$planningId, $date, $activity, $group, $guide, $cag1, $cag2, $transport, $guideFunction];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$planningId, $date, $activity, $group, $guide, $cag1, $cag2, $transport, $guideFunction];
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::INDEX, 'ROLE_ADMIN')
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::DETAIL, 'ROLE_ADMIN')
            ->setPermission(Action::NEW, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::BATCH_DELETE, 'ROLE_ADMIN');
    }
}
