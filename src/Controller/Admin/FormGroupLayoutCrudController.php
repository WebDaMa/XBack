<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class FormGroupLayoutCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'customerId', 'fileId', 'periodId', 'bookerId', 'booker', 'lastName', 'firstName', 'email', 'gsm', 'nationalRegisterNumber', 'expireDate', 'sizeInfo', 'nameShortage', 'emergencyNumber', 'licensePlate', 'typePerson', 'infoCustomer', 'infoFile', 'boardingPoint', 'activityOption', 'groupName', 'lodgingLayout', 'totalExclInsurance', 'insuranceValue'])
            ->setPaginatorPageSize(200);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('periodId')
            ->add(EntityFilter::new('agency'))
            ->add(EntityFilter::new('groupLayout'));
    }

    public function configureFields(string $pageName): iterable
    {
        $groupLayout = AssociationField::new('groupLayout');
        $id = IntegerField::new('id', 'ID');
        $customerId = IntegerField::new('customerId');
        $fileId = IntegerField::new('fileId');
        $periodId = IntegerField::new('periodId');
        $bookerId = IntegerField::new('bookerId');
        $booker = TextField::new('booker');
        $lastName = TextField::new('lastName');
        $firstName = TextField::new('firstName');
        $email = TextField::new('email');
        $birthdate = DateField::new('birthdate');
        $gsm = TextField::new('gsm');
        $nationalRegisterNumber = TextField::new('nationalRegisterNumber');
        $expireDate = TextField::new('expireDate');
        $sizeInfo = TextField::new('sizeInfo');
        $nameShortage = TextField::new('nameShortage');
        $emergencyNumber = TextField::new('emergencyNumber');
        $licensePlate = TextField::new('licensePlate');
        $typePerson = TextField::new('typePerson');
        $infoCustomer = TextareaField::new('infoCustomer');
        $infoFile = TextareaField::new('infoFile');
        $startDay = DateField::new('startDay');
        $endDay = DateField::new('endDay');
        $travelGoDate = DateField::new('travelGoDate');
        $travelBackDate = DateField::new('travelBackDate');
        $boardingPoint = TextField::new('boardingPoint');
        $activityOption = TextField::new('activityOption');
        $groupName = TextField::new('groupName');
        $lodgingLayout = TextField::new('lodgingLayout');
        $bookerPayed = Field::new('bookerPayed');
        $isCamper = Field::new('isCamper');
        $payed = Field::new('payed');
        $payedPayconiq = Field::new('payedPayconiq');
        $checkedIn = Field::new('checkedIn');
        $busToCheckedIn = Field::new('busToCheckedIn');
        $busBackCheckedIn = Field::new('busBackCheckedIn');
        $totalExclInsurance = IntegerField::new('totalExclInsurance');
        $insuranceValue = IntegerField::new('insuranceValue');
        $createdAt = DateTimeField::new('created_at');
        $modifiedAt = DateTimeField::new('modified_at');
        $size = AssociationField::new('size');
        $agency = AssociationField::new('agency');
        $location = AssociationField::new('location');
        $programType = AssociationField::new('programType');
        $lodgingType = AssociationField::new('lodgingType');
        $allInType = AssociationField::new('allInType');
        $insuranceType = AssociationField::new('insuranceType');
        $travelGoType = AssociationField::new('travelGoType');
        $travelBackType = AssociationField::new('travelBackType');
        $groupPreference = AssociationField::new('groupPreference');
        $payerCustomers = AssociationField::new('payerCustomers');
        $payer = AssociationField::new('payer');
        $payments = AssociationField::new('payments');
        $activities = AssociationField::new('activities');
        $createdBy = AssociationField::new('created_by');
        $updatedBy = AssociationField::new('updated_by');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$groupLayout, $groupPreference, $programType, $groupName, $booker, $travelGoType, $birthdate, $firstName, $lastName];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $customerId, $fileId, $periodId, $bookerId, $booker, $lastName, $firstName, $email, $birthdate, $gsm, $nationalRegisterNumber, $expireDate, $sizeInfo, $nameShortage, $emergencyNumber, $licensePlate, $typePerson, $infoCustomer, $infoFile, $startDay, $endDay, $travelGoDate, $travelBackDate, $boardingPoint, $activityOption, $groupName, $lodgingLayout, $bookerPayed, $isCamper, $payed, $payedPayconiq, $checkedIn, $busToCheckedIn, $busBackCheckedIn, $totalExclInsurance, $insuranceValue, $createdAt, $modifiedAt, $size, $agency, $location, $programType, $lodgingType, $allInType, $insuranceType, $travelGoType, $travelBackType, $groupPreference, $groupLayout, $payerCustomers, $payer, $payments, $activities, $createdBy, $updatedBy];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$groupLayout];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$groupLayout];
        }
    }
}
