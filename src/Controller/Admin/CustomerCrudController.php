<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use App\Repository\GroepRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
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

class CustomerCrudController extends AbstractCrudController
{
    /**
     * @var GroepRepository
     */
    private $groepRepository;

    /**
     * FormCheckinCrudController constructor.
     * @param GroepRepository $groepRepository
     */
    public function __construct(GroepRepository $groepRepository)
    {
        $this->groepRepository = $groepRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Customer')
            ->setEntityLabelInPlural('Customer')
            ->setSearchFields(['id', 'customerId', 'fileId', 'periodId', 'bookerId', 'booker', 'lastName', 'firstName', 'email', 'gsm', 'nationalRegisterNumber', 'expireDate', 'sizeInfo', 'nameShortage', 'emergencyNumber', 'licensePlate', 'typePerson', 'infoCustomer', 'infoFile', 'boardingPoint', 'activityOption', 'groupName', 'lodgingLayout', 'totalExclInsurance', 'insuranceValue'])
            ->setPaginatorPageSize(50)
            ->setDefaultSort(['customerId' => 'DESC']);
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
        $expireDate = DateField::new('expireDate');
        $size = AssociationField::new('size');
        $sizeInfo = TextField::new('sizeInfo');
        $nameShortage = TextField::new('nameShortage');
        $emergencyNumber = TextField::new('emergencyNumber');
        $licensePlate = TextField::new('licensePlate');
        $typePerson = TextField::new('typePerson');
        $infoCustomer = TextareaField::new('infoCustomer');
        $infoFile = TextareaField::new('infoFile');
        $agency = AssociationField::new('agency');
        $location = AssociationField::new('location');
        $startDay = DateField::new('startDay');
        $endDay = DateField::new('endDay');
        $programType = AssociationField::new('programType');
        $lodgingType = AssociationField::new('lodgingType');
        $allInType = AssociationField::new('allInType');
        $insuranceType = AssociationField::new('insuranceType');
        $travelGoType = AssociationField::new('travelGoType');
        $travelGoDate = DateField::new('travelGoDate');
        $travelBackType = AssociationField::new('travelBackType');
        $travelBackDate = DateField::new('travelBackDate');
        $boardingPoint = TextField::new('boardingPoint');
        $activityOption = TextField::new('activityOption');
        $groupName = TextField::new('groupName');
        $groupPreference = AssociationField::new('groupPreference');
        $lodgingLayout = TextField::new('lodgingLayout');
        $groupLayout = AssociationField::new('groupLayout')->setFormTypeOptions(
            [
                'query_builder' => function () {
                    return $this->groepRepository->createQueryBuilder('g')
                        ->orderBy('g.periodId', 'DESC');
                },
            ]
        );
        $payed = Field::new('payed');
        $payedPayconiq = Field::new('payedPayconiq');
        $isCamper = Field::new('isCamper');
        $checkedIn = Field::new('checkedIn');
        $totalExclInsurance = IntegerField::new('totalExclInsurance');
        $insuranceValue = IntegerField::new('insuranceValue');
        $activities = AssociationField::new('activities');
        $id = IntegerField::new('id', 'ID');
        $bookerPayed = Field::new('bookerPayed');
        $busToCheckedIn = Field::new('busToCheckedIn');
        $busBackCheckedIn = Field::new('busBackCheckedIn');
        $createdAt = DateTimeField::new('created_at');
        $modifiedAt = DateTimeField::new('modified_at');
        $payerCustomers = AssociationField::new('payerCustomers');
        $payer = AssociationField::new('payer');
        $payments = AssociationField::new('payments');
        $createdBy = AssociationField::new('created_by');
        $updatedBy = AssociationField::new('updated_by');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$customerId, $firstName, $lastName, $email, $periodId, $gsm, $nationalRegisterNumber];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $customerId, $fileId, $periodId, $bookerId, $booker, $lastName, $firstName, $email, $birthdate, $gsm, $nationalRegisterNumber, $expireDate, $sizeInfo, $nameShortage, $emergencyNumber, $licensePlate, $typePerson, $infoCustomer, $infoFile, $startDay, $endDay, $travelGoDate, $travelBackDate, $boardingPoint, $activityOption, $groupName, $lodgingLayout, $bookerPayed, $isCamper, $payed, $payedPayconiq, $checkedIn, $busToCheckedIn, $busBackCheckedIn, $totalExclInsurance, $insuranceValue, $createdAt, $modifiedAt, $size, $agency, $location, $programType, $lodgingType, $allInType, $insuranceType, $travelGoType, $travelBackType, $groupPreference, $groupLayout, $payerCustomers, $payer, $payments, $activities, $createdBy, $updatedBy];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$customerId, $fileId, $periodId, $bookerId, $booker, $lastName, $firstName, $email, $birthdate, $gsm, $nationalRegisterNumber, $expireDate, $size, $sizeInfo, $nameShortage, $emergencyNumber, $licensePlate, $typePerson, $infoCustomer, $infoFile, $agency, $location, $startDay, $endDay, $programType, $lodgingType, $allInType, $insuranceType, $travelGoType, $travelGoDate, $travelBackType, $travelBackDate, $boardingPoint, $activityOption, $groupName, $groupPreference, $lodgingLayout, $groupLayout, $payed, $payedPayconiq, $isCamper, $checkedIn, $totalExclInsurance, $insuranceValue, $activities];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$customerId, $fileId, $periodId, $bookerId, $booker, $lastName, $firstName, $email, $birthdate, $gsm, $nationalRegisterNumber, $expireDate, $size, $sizeInfo, $nameShortage, $emergencyNumber, $licensePlate, $typePerson, $infoCustomer, $infoFile, $agency, $location, $startDay, $endDay, $programType, $lodgingType, $allInType, $insuranceType, $travelGoType, $travelGoDate, $travelBackType, $travelBackDate, $boardingPoint, $activityOption, $groupName, $groupPreference, $lodgingLayout, $groupLayout, $payed, $payedPayconiq, $isCamper, $checkedIn, $totalExclInsurance, $insuranceValue, $activities];
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
