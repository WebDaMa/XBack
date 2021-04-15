<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use App\Utils\Calculations;
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
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;

class FormCheckinCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'customerId', 'fileId', 'periodId', 'bookerId', 'booker', 'lastName', 'firstName', 'email', 'gsm', 'nationalRegisterNumber', 'expireDate', 'sizeInfo', 'nameShortage', 'emergencyNumber', 'licensePlate', 'typePerson', 'infoCustomer', 'infoFile', 'boardingPoint', 'activityOption', 'groupName', 'lodgingLayout', 'totalExclInsurance', 'insuranceValue'])
            ->setPaginatorPageSize(50);
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
        $checkedIn = Field::new('checkedIn');
        $firstName = TextField::new('firstName');
        $lastName = TextField::new('lastName');
        $booker = TextField::new('booker');
        $groupName = TextField::new('groupName');
        $birthdate = DateField::new('birthdate');
        $nationalRegisterNumber = TextField::new('nationalRegisterNumber');
        $expireDate = DateField::new('expireDate');
        $lodgingLayout = TextField::new('lodgingLayout');
        $allInType = AssociationField::new('allInType');
        $groupLayout = AssociationField::new('groupLayout');
        $id = IntegerField::new('id', 'ID');
        $customerId = IntegerField::new('customerId');
        $fileId = IntegerField::new('fileId');
        $periodId = IntegerField::new('periodId');
        $bookerId = IntegerField::new('bookerId');
        $email = TextField::new('email');
        $gsm = TextField::new('gsm');
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
        $bookerPayed = Field::new('bookerPayed');
        $isCamper = Field::new('isCamper');
        $payed = Field::new('payed');
        $payedPayconiq = Field::new('payedPayconiq');
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
        $file = FileUploadType::new('updated_by');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$periodId, $checkedIn, $firstName, $lastName, $booker, $groupName, $birthdate, $nationalRegisterNumber, $expireDate, $lodgingLayout, $allInType, $groupLayout];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $customerId, $fileId, $periodId, $bookerId, $booker, $lastName, $firstName, $email, $birthdate, $gsm, $nationalRegisterNumber, $expireDate, $sizeInfo, $nameShortage, $emergencyNumber, $licensePlate, $typePerson, $infoCustomer, $infoFile, $startDay, $endDay, $travelGoDate, $travelBackDate, $boardingPoint, $activityOption, $groupName, $lodgingLayout, $bookerPayed, $isCamper, $payed, $payedPayconiq, $checkedIn, $busToCheckedIn, $busBackCheckedIn, $totalExclInsurance, $insuranceValue, $createdAt, $modifiedAt, $size, $agency, $location, $programType, $lodgingType, $allInType, $insuranceType, $travelGoType, $travelBackType, $groupPreference, $groupLayout, $payerCustomers, $payer, $payments, $activities, $createdBy, $updatedBy];
        } elseif (Crud::PAGE_NEW === $pageName) {
            $rep = $this->getDoctrine()->getRepository(Customer::class);
            $currentPeriod = Calculations::getCurrentPeriodId();
            $randomBookerID = $currentPeriod . rand(1000000, 3000000);
            $lastId = $rep->getLastId();
            $defaultCustomer = $currentPeriod . ($lastId + 1);
            $randomFile = $currentPeriod . rand(1000000, 7000000);

            // Fill in form with defaults
            $periodId->setFormTypeOption('data', $currentPeriod);
            $bookerId->setFormTypeOption('data', $randomBookerID);
            $customerId->setFormTypeOption('data', $defaultCustomer);
            $fileId->setFormTypeOption('data', $randomFile);

            return [$checkedIn, $periodId, $bookerId, $customerId, $fileId, $firstName, $lastName, $booker, $groupName, $birthdate, $nationalRegisterNumber, $expireDate, $lodgingLayout, $allInType, $groupLayout, $agency, $programType];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$checkedIn, $periodId, $bookerId, $customerId, $fileId, $firstName, $lastName, $booker, $groupName, $birthdate, $nationalRegisterNumber, $expireDate, $lodgingLayout, $allInType, $groupLayout, $agency, $programType];
        }
    }
}
