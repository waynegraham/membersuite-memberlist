<?php
/*
Membersuite Object Types

*/

class msDomainObject {

	public $CLASS_NAME = 'DomainObject';

	public function __construct( $data ) {
		if ( is_object( $data ) ) {
			$data = $this->create_dictionary( $data );
		}
		$this->load_data( $data );
	}

	protected function load_data( $data ) {
	}

	protected function create_dictionary( $data ) {
		$resdata = $this->object_to_array( $data->bFields->bKeyValueOfstringanyType );
		$data    = array();
		foreach ( $resdata as $result ) {
			$data[ $result['bKey'] ] = $result['bValue'];
		}
		return $data;
	}

	protected function object_to_array( $data ) {
		if ( ( ! is_array( $data ) ) and ( ! is_object( $data ) ) ) {
			return $data;
		}

		$result = array();
		$data   = (array) $data;
		foreach ( $data as $key => $value ) {
			if ( is_object( $value ) ) {
				$value = (array) $value;
			}
			if ( is_array( $value ) ) {
				$result[ $key ] = $this->object_to_array( $value );
			} else {
				$result[ $key ] = $value;
			}
		}
		return $result;
	}
}

class msAggregate extends msDomainObject {

	public $CLASS_NAME = 'Aggregate';
	public $ClassType  = 'Aggregate';

	// Fields
	public $ID;
	public $Name;
	public $Keywords;
	public $LastModifiedBy;
	public $LastModifiedDate;
	public $CreatedDate;
	public $CreatedBy;
	public $LockedForDeletion;
	public $IsConfiguration;
	public $IsSealed;
	public $SystemTimestamp;

	protected function load_data( $data ) {
		if ( isset( $data['ID'] ) ) {
			$this->ID = $data['ID'];
		}
		if ( isset( $data['Name'] ) ) {
			$this->Name = $data['Name'];
		}
		if ( isset( $data['LastModifiedBy'] ) ) {
			$this->LastModifiedBy = $data['LastModifiedBy'];
		}
		if ( isset( $data['LastModifiedDate'] ) ) {
			$this->LastModifiedDate = $data['LastModifiedDate'];
		}
		if ( isset( $data['CreatedDate'] ) ) {
			$this->CreatedDate = $data['CreatedDate'];
		}
		if ( isset( $data['CreatedBy'] ) ) {
			$this->CreatedBy = $data['CreatedBy'];
		}
		if ( isset( $data['IsConfiguration'] ) ) {
			$this->IsConfiguration = $data['IsConfiguration'];
		}
		if ( isset( $data['SystemTimestamp'] ) ) {
			$this->SystemTimestamp = $data['SystemTimestamp'];
		}
	}
}

class msEntity extends msAggregate {

	public $CLASS_NAME = 'Entity';
	public $ClassType  = 'Entity';

	protected function load_data( $data ) {
		parent::load_data( $data );

		if ( isset( $data['Owner'] ) ) {
			$this->Owner = $data['Owner'];
		}
		if ( isset( $data['EmailAddress'] ) ) {
			$this->EmailAddress = $data['EmailAddress'];
		}
		if ( isset( $data['Addresses'] ) ) {
			$this->Addresses = $data['Addresses'];
		}
		if ( isset( $data['TaxExempt'] ) ) {
			$this->TaxExempt = $data['TaxExempt'];
		}
		if ( isset( $data['DefaultCreditTerms'] ) ) {
			$this->DefaultCreditTerms = $data['DefaultCreditTerms'];
		}
		if ( isset( $data['PhoneNumbers'] ) ) {
			$this->PhoneNumbers = $data['PhoneNumbers'];
		}
		if ( isset( $data['PreferredAddressType'] ) ) {
			$this->PreferredAddressType = $data['PreferredAddressType'];
		}
		if ( isset( $data['PreferredPhoneNumberType'] ) ) {
			$this->PreferredPhoneNumberType = $data['PreferredPhoneNumberType'];
		}
		if ( isset( $data['DonorLevel'] ) ) {
			$this->DonorLevel = $data['DonorLevel'];
		}
		if ( isset( $data['SourceCode'] ) ) {
			$this->SourceCode = $data['SourceCode'];
		}
		if ( isset( $data['MediaCode'] ) ) {
			$this->MediaCode = $data['MediaCode'];
		}
		if ( isset( $data['WebSite'] ) ) {
			$this->WebSite = $data['WebSite'];
		}
		if ( isset( $data['Notes'] ) ) {
			$this->Notes = $data['Notes'];
		}
		if ( isset( $data['Image'] ) ) {
			$this->Image = $data['Image'];
		}
		if ( isset( $data['LocalID'] ) ) {
			$this->LocalID = $data['LocalID'];
		}
		if ( isset( $data['LegislativeDistricts'] ) ) {
			$this->LegislativeDistricts = $data['LegislativeDistricts'];
		}
	}

	public $Owner;
	public $SortName;
	public $EmailAddress;
	public $Addresses;
	public $TaxExempt;
	public $DefaultCreditTerms;
	public $PhoneNumbers;
	public $PreferredAddressType;
	public $PreferredPhoneNumberType;
	public $DonorLevel;
	public $SourceCode;
	public $MediaCode;
	public $WebSite;
	public $Notes;
	public $Image;
	public $LocalID;
	public $LegislativeDistricts;
}

class msIndividual extends msEntity {

	public $ClassType = 'Individual';

	public $FirstName;
	public $MiddleName;
	public $LastName;
	public $Nickname;
	public $LocalID;
	public $Name;
	public $DoNotEmail;
	public $OptOuts;
	public $DoNotFax;
	public $DoNotMail;
	public $Age;
	public $Type;
	public $DateOfBirth;
	public $EmailAddress2;
	public $EmailAddress3;
	public $Title;
	public $Prefix;
	public $Suffix;
	public $Designation;
	public $Company;
	public $SeasonalAddressStart;
	public $SeasonalAddressEnd;

	protected function load_data( $data ) {
		parent::load_data( $data );

		if ( $data['FirstName'] ) {
			$this->FirstName = $data['FirstName'];
		}
		if ( $data['MiddleName'] ) {
			$this->MiddleName = $data['MiddleName'];
		}
		if ( $data['LastName'] ) {
			$this->LastName = $data['LastName'];
		}
		if ( $data['Nickname'] ) {
			$this->Nickname = $data['Nickname'];
		}
		if ( $data['DoNotEmail'] ) {
			$this->DoNotEmail = $data['DoNotEmail'];
		}
		if ( $data['OptOuts'] ) {
			$this->OptOuts = $data['OptOuts'];
		}
		if ( $data['DoNotFax'] ) {
			$this->DoNotFax = $data['DoNotFax'];
		}
		if ( $data['DoNotMail'] ) {
			$this->DoNotMail = $data['DoNotMail'];
		}
		if ( $data['Age'] ) {
			$this->Age = $data['Age'];
		}
		if ( $data['Type'] ) {
			$this->Type = $data['Type'];
		}
		if ( $data['DateOfBirth'] ) {
			$this->DateOfBirth = $data['DateOfBirth'];
		}
		if ( $data['EmailAddress2'] ) {
			$this->EmailAddress2 = $data['EmailAddress2'];
		}
		if ( $data['EmailAddress3'] ) {
			$this->EmailAddress3 = $data['EmailAddress3'];
		}
		if ( $data['Title'] ) {
			$this->Title = $data['Title'];
		}
		if ( $data['Prefix'] ) {
			$this->Prefix = $data['Prefix'];
		}
		if ( $data['Suffix'] ) {
			$this->Suffix = $data['Suffix'];
		}
		if ( $data['Designation'] ) {
			$this->Designation = $data['Designation'];
		}
		if ( $data['Company'] ) {
			$this->Company = $data['Company'];
		}
		if ( $data['SeasonalAddressStart'] ) {
			$this->SeasonalAddressStart = $data['SeasonalAddressStart'];
		}
		if ( $data['SeasonalAddressEnd'] ) {
			$this->SeasonalAddressEnd = $data['SeasonalAddressEnd'];
		}
	}
}

class msUser extends msAggregate {

	public $ClassType          = 'CustomerUser';
	public $FirstName          = 'FirstName';
	public $LastName           = 'LastName';
	public $Name               = 'Name';
	public $EmailAddress       = 'EmailAddress';
	public $PasswordHash       = 'PasswordHash';
	public $Department         = 'Department';
	public $IsSuspended        = 'IsSuspended';
	public $IsSuperUser        = 'IsSuperUser';
	public $TimeZone           = 'TimeZone';
	public $PhoneNumber        = 'PhoneNumber';
	public $Notes              = 'Notes';
	public $SecurityQuestion   = 'SecurityQuestion';
	public $SecurityAnswer     = 'SecurityAnswer';
	public $MustChangePassword = 'MustChangePassword';

	public function __construct( $datauser = '' ) {
		if ( $datauser ) {
			$dataarray = $this->ConvertToArray( $datauser->bFields->bKeyValueOfstringanyType );

			$data = array();
			foreach ( $dataarray as $result ) {
				$data[ $result['bKey'] ] = $result['bValue'];
			}
		} else {
			$data = '';
		}
		if ( isset( $data['FirstName'] ) ) {
			$this->FirstName = $data['FirstName'];
		}

		if ( isset( $data['LastName'] ) ) {
			$this->LastName = $data['LastName'];
		}
		if ( isset( $data['EmailAddress'] ) ) {
			$this->EmailAddress = $data['EmailAddress'];
		}
		if ( isset( $data['PasswordHash'] ) ) {
			$this->PasswordHash = $data['PasswordHash'];
		}
		if ( isset( $data['Department'] ) ) {
			$this->Department = $data['Department'];
		}
		if ( isset( $data['IsSuspended'] ) ) {
			$this->IsSuspended = $data['IsSuspended'];
		}
		if ( isset( $data['IsSuperUser'] ) ) {
			$this->IsSuperUser = $data['IsSuperUser'];
		}
		if ( isset( $data['TimeZone'] ) ) {
			$this->TimeZone = $data['TimeZone'];
		}

		if ( isset( $data['PhoneNumber'] ) ) {
			$this->PhoneNumber = $data['PhoneNumber'];
		}
		if ( isset( $data['Notes'] ) ) {
			$this->Notes = $data['Notes'];
		}
		if ( isset( $data['SecurityQuestion'] ) ) {
			$this->SecurityQuestion = $data['SecurityQuestion'];
		}
		if ( isset( $data['SecurityAnswer'] ) ) {
			$this->SecurityAnswer = $data['SecurityAnswer'];
		}
		if ( isset( $data['MustChangePassword'] ) ) {
			$this->MustChangePassword = $data['MustChangePassword'];
		}
		if ( isset( $data['ID'] ) ) {
			$this->ID = $data['ID'];
		}
		if ( isset( $data['SystemTimestamp'] ) ) {
			$this->SystemTimestamp = $data['SystemTimestamp'];
		}
		if ( isset( $data['Name'] ) ) {
			$this->Name = $data['Name'];
		}
	}

	public function ConvertToArray( $data ) {
		if ( ( ! is_array( $data ) ) and ( ! is_object( $data ) ) ) {
			return 'xxx';
		} //$data;

		$result = array();

		$data = (array) $data;
		foreach ( $data as $key => $value ) {
			if ( is_object( $value ) ) {
				$value = (array) $value;
			}
			if ( is_array( $value ) ) {
				$result[ $key ] = $this->ConvertToArray( $value );
			} else {
				$result[ $key ] = $value;
			}
		}

		return $result;
	}
}

class GetSafeValue extends msIndividual {

	public $ID;
	public $Name;

	public function __construct( $datauser ) {
		$dataarray = $this->object_to_array( $datauser->bFields->bKeyValueOfstringanyType );

		$data = array();
		foreach ( $dataarray as $result ) {
			$data[ $result['bKey'] ] = $result['bValue'];
		}

		if ( $data['FirstName'] ) {
			$this->FirstName = $data['FirstName'];
		}

		if ( $data['MiddleName'] ) {
			$this->MiddleName = $data['MiddleName'];
		}
		if ( $data['LastName'] ) {
			$this->LastName = $data['LastName'];
		}
		if ( $data['Nickname'] ) {
			$this->Nickname = $data['Nickname'];
		}
		if ( $data['DoNotEmail'] ) {
			$this->DoNotEmail = $data['DoNotEmail'];
		}
		if ( $data['OptOuts'] ) {
			$this->OptOuts = $data['OptOuts'];
		}
		if ( $data['DoNotFax'] ) {
			$this->DoNotFax = $data['DoNotFax'];
		}
		if ( $data['DoNotMail'] ) {
			$this->DoNotMail = $data['DoNotMail'];
		}
		if ( $data['Age'] ) {
			$this->Age = $data['Age'];
		}
		if ( $data['Type'] ) {
			$this->Type = $data['Type'];
		}
		if ( $data['DateOfBirth'] ) {
			$this->DateOfBirth = $data['DateOfBirth'];
		}
		if ( $data['EmailAddress2'] ) {
			$this->EmailAddress2 = $data['EmailAddress2'];
		}
		if ( $data['EmailAddress3'] ) {
			$this->EmailAddress3 = $data['EmailAddress3'];
		}
		if ( $data['Title'] ) {
			$this->Title = $data['Title'];
		}
		if ( $data['Prefix'] ) {
			$this->Prefix = $data['Prefix'];
		}
		if ( $data['Suffix'] ) {
			$this->Suffix = $data['Suffix'];
		}
		if ( $data['Designation'] ) {
			$this->Designation = $data['Designation'];
		}
		if ( $data['Company'] ) {
			$this->Company = $data['Company'];
		}
		if ( $data['SeasonalAddressStart'] ) {
			$this->SeasonalAddressStart = $data['SeasonalAddressStart'];
		}

		if ( $data['SeasonalAddressEnd'] ) {
			$this->SeasonalAddressEnd = $data['SeasonalAddressEnd'];
		}

		if ( isset( $data['LocalID'] ) ) {
			$this->LocalID = $data['LocalID'];
		}

		if ( isset( $data['Name'] ) ) {
			$this->Name = $data['Name'];
		}

		if ( isset( $data['ID'] ) ) {
			$this->ID = $data['ID'];
		}
	}
}

class msEntitlement extends msAggregate {

	public $CLASS_NAME        = 'Entitlement';
	public $ClassType         = 'Entitlement';
	public $Owner             = 'Owner';
	public $Quantity          = 'Quantity';
	public $QuantityAvailable = 'QuantityAvailable';
	public $AvailableFrom     = 'AvailableFrom';
	public $AvailableUntil    = 'AvailableUntil';
	public $Comments          = 'Comments';
	public $Order             = 'Order';
	public $OrderLineItemID   = 'OrderLineItemID';
	public $SecurityLock      = 'SecurityLock';
}

class msCustomEntitlement extends msEntitlement {

	public $CLASS_NAME = 'CustomEntitlement';
	public $ClassType  = 'CustomEntitlement';
	public $CustomType = 'CustomType';
}

class msAuditLog extends msAggregate {

	public $CLASS_NAME          = 'AuditLog';
	public $ClassType           = 'AuditLog';
	public $Type                = 'Type';
	public $AffectedFields      = 'AffectedFields';
	public $Actor               = 'Actor';
	public $AffectedRecord_Type = 'AffectedRecord_Type';
	public $AffectedRecord_ID   = 'AffectedRecord_ID';
	public $AffectedRecord_Name = 'AffectedRecord_Name';
	public $Description         = 'Description';
	public $ServiceName         = 'ServiceName';
	public $SecurityLock        = 'SecurityLock';
}

class msEventBase extends msAggregate {

	public $CLASS_NAME                    = 'EventBase';
	public $ClassType                     = 'EventBase';
	public $BusinessUnit                  = 'BusinessUnit';
	public $ConfirmationEmail             = 'ConfirmationEmail';
	public $CertificationComponent        = 'CertificationComponent';
	public $Description                   = 'Description';
	public $ShortSummary                  = 'ShortSummary';
	public $StartDate                     = 'StartDate';
	public $EndDate                       = 'EndDate';
	public $RegistrationMode              = 'RegistrationMode';
	public $PreRegistrationCutOffDate     = 'PreRegistrationCutOffDate';
	public $EarlyRegistrationCutOffDate   = 'EarlyRegistrationCutOffDate';
	public $RegularRegistrationCutOffDate = 'RegularRegistrationCutOffDate';
	public $LateRegistrationCutOffDate    = 'LateRegistrationCutOffDate';
	public $PostToWeb                     = 'PostToWeb';
	public $RemoveFromWeb                 = 'RemoveFromWeb';
	public $Agenda                        = 'Agenda';
	public $Minutes                       = 'Minutes';
	public $FeaturedPriority              = 'FeaturedPriority';
	public $FeaturedFrom                  = 'FeaturedFrom';
	public $FeaturedUntil                 = 'FeaturedUntil';
	public $VisibleInPortal               = 'VisibleInPortal';
	public $TimeZone                      = 'TimeZone';
	public $ParentEvent                   = 'ParentEvent';
	public $MustBeRegisteredForParent     = 'MustBeRegisteredForParent';
	public $Capacity                      = 'Capacity';
	public $RegistrationGoal              = 'RegistrationGoal';
	public $RevenueGoal                   = 'RevenueGoal';
	public $ProjectedAttendance           = 'ProjectedAttendance';
	public $GuaranteedAttendance          = 'GuaranteedAttendance';
	public $AllowWaitList                 = 'AllowWaitList';
	public $RequiresApproval              = 'RequiresApproval';
	public $Url                           = 'Url';
	public $RegistrationOpenDate          = 'RegistrationOpenDate';
	public $RegistrationCloseDate         = 'RegistrationCloseDate';
	public $Courses                       = 'Courses';
	public $Speakers                      = 'Speakers';
	public $RegistrationUrl               = 'RegistrationUrl';
	public $LocalID                       = 'LocalID';
}

class msEvent extends msEventBase {

	public $CLASS_NAME                            = 'Event';
	public $ClassType                             = 'Event';
	public $Code                                  = 'Code';
	public $Type                                  = 'Type';
	public $Category                              = 'Category';
	public $EnableAbstracts                       = 'EnableAbstracts';
	public $AllowEditAbstracts                    = 'AllowEditAbstracts';
	public $AcceptAbstractsFrom                   = 'AcceptAbstractsFrom';
	public $AcceptAbstractsUntil                  = 'AcceptAbstractsUntil';
	public $Location                              = 'Location';
	public $Chapter                               = 'Chapter';
	public $OrganizationalLayer                   = 'OrganizationalLayer';
	public $Section                               = 'Section';
	public $MerchantAccount                       = 'MerchantAccount';
	public $EnableGroupRegistrations              = 'EnableGroupRegistrations';
	public $IncludeInEntitySearch                 = 'IncludeInEntitySearch';
	public $InviteOnly                            = 'InviteOnly';
	public $AllowGroupRegistrationsFrom           = 'AllowGroupRegistrationsFrom';
	public $AllowGroupRegistrationsUntil          = 'AllowGroupRegistrationsUntil';
	public $WorkshopSubmissionInstructions        = 'WorkshopSubmissionInstructions';
	public $WorkshopConfirmationInstructions      = 'WorkshopConfirmationInstructions';
	public $RegistrationTypeSelectionInstructions = 'RegistrationTypeSelectionInstructions';
	public $SessionSelectionInstructions          = 'SessionSelectionInstructions';
	public $PreceedingEvent                       = 'PreceedingEvent';
	public $NextEvent                             = 'NextEvent';
	public $RegistrationFeeInstructions           = 'RegistrationFeeInstructions';
	public $RegistrationFormInstructions          = 'RegistrationFormInstructions';
	public $AcknowledgementText                   = 'AcknowledgementText';
	public $GroupRegistrationRelationshipTypes    = 'GroupRegistrationRelationshipTypes';
	public $DisplayStartEndDateTimesAs            = 'DisplayStartEndDateTimesAs';
	public $IsClosed                              = 'IsClosed';
}

class msFiscalYear extends msAggregate {

	public $CLASS_NAME      = 'FiscalYear';
	public $ClassType       = 'FiscalYear';
	public $IsConfiguration = 'IsConfiguration';
	public $Year            = 'Year';
	public $BusinessUnit    = 'BusinessUnit';
	public $IsClosed        = 'IsClosed';
	public $ClosedBy        = 'ClosedBy';
	public $StartDate       = 'StartDate';
	public $EndDate         = 'EndDate';
	public $Periods         = 'Periods';
	public $SecurityLock    = 'SecurityLock';
}


class msBatch extends msAggregate {

	public $CLASS_NAME     = 'Batch';
	public $ClassType      = 'Batch';
	public $IsDefault      = 'IsDefault';
	public $Description    = 'Description';
	public $DatePosted     = 'DatePosted';
	public $DateClosed     = 'DateClosed';
	public $DateExported   = 'DateExported';
	public $ClosedBy       = 'ClosedBy';
	public $PostedBy       = 'PostedBy';
	public $FiscalYear     = 'FiscalYear';
	public $FiscalPeriod   = 'FiscalPeriod';
	public $Type           = 'Type';
	public $BusinessUnit   = 'BusinessUnit';
	public $Status         = 'Status';
	public $DateVerified   = 'DateVerified';
	public $Date           = 'Date';
	public $ControlTotal   = 'ControlTotal';
	public $ControlCount   = 'ControlCount';
	public $RestrictAccess = 'RestrictAccess';
	public $SecurityRoles  = 'SecurityRoles';
	public $UserGroups     = 'UserGroups';
	public $LocalID        = 'LocalID';
	public $SecurityLock   = 'SecurityLock';
}

class msBatchMember extends msAggregate {

	public $CLASS_NAME = 'BatchMember';
	public $ClassType  = 'BatchMember';
	public $Date       = 'Date';
	public $Memo       = 'Memo';
	public $Batch      = 'Batch';
	public $IsVoid     = 'IsVoid';
	public $SourceCode = 'SourceCode';
	public $MediaCode  = 'MediaCode';
	public $LocalID    = 'LocalID';
}

class msCredit extends msBatchMember {

	public $CLASS_NAME        = 'Credit';
	public $ClassType         = 'Credit';
	public $BillTo            = 'BillTo';
	public $InvoiceAdjustment = 'InvoiceAdjustment';
	public $Invoice           = 'Invoice';
	public $BusinessUnit      = 'BusinessUnit';
	public $ExpenseAccount    = 'ExpenseAccount';
	public $LiabilityAccount  = 'LiabilityAccount';
	public $UseFrom           = 'UseFrom';
	public $UseThrough        = 'UseThrough';
	public $Notes             = 'Notes';
	public $Total             = 'Total';
	public $AmountUsed        = 'AmountUsed';
}

class msInvoice extends msBatchMember {

	public $CLASS_NAME               = 'Invoice';
	public $ClassType                = 'Invoice';
	public $BusinessUnit             = 'BusinessUnit';
	public $AccountsReceivableGLCode = 'AccountsReceivableGLCode';
	public $DueDate                  = 'DueDate';
	public $BillTo                   = 'BillTo';
	public $BillingAddress           = 'BillingAddress';
	public $Order                    = 'Order';
	public $BillingEmailAddress      = 'BillingEmailAddress';
	public $Terms                    = 'Terms';
	public $PurchaseOrderNumber      = 'PurchaseOrderNumber';
	public $CustomerMessage          = 'CustomerMessage';
	public $Total                    = 'Total';
	public $BalanceDue               = 'BalanceDue';
	public $ToBePrinted              = 'ToBePrinted';
	public $ToBeEmailed              = 'ToBeEmailed';
	public $Type                     = 'Type';
	public $Notes                    = 'Notes';
	public $ProForma                 = 'ProForma';
	public $InsertionOrder           = 'InsertionOrder';
	public $LineItems                = 'LineItems';
}

class msWriteOff extends msBatchMember {

	public $CLASS_NAME               = 'WriteOff';
	public $ClassType                = 'WriteOff';
	public $BusinessUnit             = 'BusinessUnit';
	public $Total                    = 'Total';
	public $Invoice                  = 'Invoice';
	public $Customer                 = 'Customer';
	public $AccountsReceivableGLCode = 'AccountsReceivableGLCode';
	public $Method                   = 'Method';
	public $Notes                    = 'Notes';
	public $LineItems                = 'LineItems';
	public $WriteOffGLAccount        = 'WriteOffGLAccount';
}

class msRefund extends msBatchMember {

	public $CLASS_NAME      = 'Refund';
	public $ClassType       = 'Refund';
	public $RefundTo        = 'RefundTo';
	public $RefundAddress   = 'RefundAddress';
	public $CheckNumber     = 'CheckNumber';
	public $CheckDate       = 'CheckDate';
	public $TransactionID   = 'TransactionID';
	public $Paid            = 'Paid';
	public $LineItems       = 'LineItems';
	public $Notes           = 'Notes';
	public $PostToSubLedger = 'PostToSubLedger';
	public $Total           = 'Total';
}

class msPayment extends msBatchMember {

	public $CLASS_NAME               = 'Payment';
	public $ClassType                = 'Payment';
	public $LinkedPayment            = 'LinkedPayment';
	public $Owner                    = 'Owner';
	public $BusinessUnit             = 'BusinessUnit';
	public $Order                    = 'Order';
	public $Total                    = 'Total';
	public $ReferenceNumber          = 'ReferenceNumber';
	public $PaymentMethod            = 'PaymentMethod';
	public $CreditCardType           = 'CreditCardType';
	public $LineItems                = 'LineItems';
	public $Notes                    = 'Notes';
	public $MerchantAccount          = 'MerchantAccount';
	public $TransactionID            = 'TransactionID';
	public $CreditCardLastFiveDigits = 'CreditCardLastFiveDigits';
}

class msGift extends msBatchMember {

	public $CLASS_NAME            = 'Gift';
	public $ClassType             = 'Gift';
	public $Type                  = 'Type';
	public $SubType               = 'SubType';
	public $IsAnonymous           = 'IsAnonymous';
	public $Donor                 = 'Donor';
	public $Order                 = 'Order';
	public $OrderLineItemID       = 'OrderLineItemID';
	public $Product               = 'Product';
	public $Campaign              = 'Campaign';
	public $Fund                  = 'Fund';
	public $Appeal                = 'Appeal';
	public $Package               = 'Package';
	public $MasterGift            = 'MasterGift';
	public $ListAs                = 'ListAs';
	public $Amount                = 'Amount';
	public $Notes                 = 'Notes';
	public $StockSymbol           = 'StockSymbol';
	public $NumberOfShares        = 'NumberOfShares';
	public $Status                = 'Status';
	public $PledgeStartDate       = 'PledgeStartDate';
	public $RecurrenceTemplate    = 'RecurrenceTemplate';
	public $NextTransactionDue    = 'NextTransactionDue';
	public $NextTransactionAmount = 'NextTransactionAmount';
	public $BalanceDue            = 'BalanceDue';
	public $InstallmentID         = 'InstallmentID';
	public $ReceiptStatus         = 'ReceiptStatus';
	public $ReceiptDate           = 'ReceiptDate';
	public $Receipt               = 'Receipt';
	public $AcknowledgmentStatus  = 'AcknowledgmentStatus';
	public $AcknowledgmentDate    = 'AcknowledgmentDate';
	public $AcknowledgmentLetter  = 'AcknowledgmentLetter';
	public $PaymentMethod         = 'PaymentMethod';
	public $CreditCardType        = 'CreditCardType';
	public $PaymentReference      = 'PaymentReference';
	public $Tributes              = 'Tributes';
	public $Installments          = 'Installments';
	public $Attributes            = 'Attributes';
	public $Solicitors            = 'Solicitors';
	public $Premiums              = 'Premiums';
	public $Splits                = 'Splits';
}

class msGiftAttribute {

	public $CLASS_NAME  = 'GiftAttribute';
	public $ClassType   = 'GiftAttribute';
	public $Category    = 'Category';
	public $Description = 'Description';
	public $Date        = 'Date';
	public $Comments    = 'Comments';
}

class msGiftSplit {

	public $CLASS_NAME = 'GiftSplit';
	public $ClassType  = 'GiftSplit';
	public $Fund       = 'Fund';
	public $Amount     = 'Amount';
	public $Comments   = 'Comments';
}

class msGiftInstallment {

	public $CLASS_NAME    = 'GiftInstallment';
	public $ClassType     = 'GiftInstallment';
	public $InstallmentID = 'InstallmentID';
	public $Date          = 'Date';
	public $Amount        = 'Amount';
	public $AmountPaid    = 'AmountPaid';
	public $Comments      = 'Comments';
}

class msGiftTribute {

	public $CLASS_NAME = 'GiftTribute';
	public $ClassType  = 'GiftTribute';
	public $Tribute    = 'Tribute';
	public $Comments   = 'Comments';
}

class msGiftPremium {

	public $CLASS_NAME      = 'GiftPremium';
	public $ClassType       = 'GiftPremium';
	public $Premium         = 'Premium';
	public $Quantity        = 'Quantity';
	public $FairMarketValue = 'FairMarketValue';
	public $Order           = 'Order';
	public $OrderLineItemID = 'OrderLineItemID';
	public $Comments        = 'Comments';
}

class msGiftSolicitor {

	public $CLASS_NAME = 'GiftSolicitor';
	public $ClassType  = 'GiftSolicitor';
	public $Solicitor  = 'Solicitor';
	public $Amount     = 'Amount';
	public $Comments   = 'Comments';
}

class msExtensionService extends msAggregate {

	public $CLASS_NAME       = 'ExtensionService';
	public $ClassType        = 'ExtensionService';
	public $IsConfiguration  = 'IsConfiguration';
	public $Transport        = 'Transport';
	public $Uri              = 'Uri';
	public $LastAccess       = 'LastAccess';
	public $Faulted          = 'Faulted';
	public $LastErrorMessage = 'LastErrorMessage';
	public $DisabledUntil    = 'DisabledUntil';
	public $IsActive         = 'IsActive';
	public $SecurityLock     = 'SecurityLock';
}

class msOrder extends msAggregate {

	public $CLASS_NAME                = 'Order';
	public $ClassType                 = 'Order';
	public $AmountDueNow              = 'AmountDueNow';
	public $HasGeneratedCEUCredits    = 'HasGeneratedCEUCredits';
	public $Batch                     = 'Batch';
	public $TrackingNumber            = 'TrackingNumber';
	public $ShipDate                  = 'ShipDate';
	public $CustomerNotes             = 'CustomerNotes';
	public $Date                      = 'Date';
	public $SourceCode                = 'SourceCode';
	public $MediaCode                 = 'MediaCode';
	public $ShipTo                    = 'ShipTo';
	public $BillTo                    = 'BillTo';
	public $PaymentMethod             = 'PaymentMethod';
	public $PaymentReferenceNumber    = 'PaymentReferenceNumber';
	public $MerchantAccount           = 'MerchantAccount';
	public $CreditCardNumber          = 'CreditCardNumber';
	public $ACHAccountNumber          = 'ACHAccountNumber';
	public $ACHRoutingNumber          = 'ACHRoutingNumber';
	public $BillingTemplate           = 'BillingTemplate';
	public $CreditCardExpirationDate  = 'CreditCardExpirationDate';
	public $CreditCardAuthorizationID = 'CreditCardAuthorizationID';
	public $CreditCardType            = 'CreditCardType';
	public $CCVCode                   = 'CCVCode';
	public $ShippingAddress           = 'ShippingAddress';
	public $BillingAddress            = 'BillingAddress';
	public $BillingEmailAddress       = 'BillingEmailAddress';
	public $DiscountCodes             = 'DiscountCodes';
	public $Status                    = 'Status';
	public $LocalID                   = 'LocalID';
	public $Discount                  = 'Discount';
	public $Total                     = 'Total';
	public $Notes                     = 'Notes';
	public $InvoiceType               = 'InvoiceType';
	public $IsCreditCardEncrypted     = 'IsCreditCardEncrypted';
	public $Memo                      = 'Memo';
	public $LineItems                 = 'LineItems';
	public $PurchaseOrderNumber       = 'PurchaseOrderNumber';
	public $ShippingMethod            = 'ShippingMethod';
	public $MembershipRenewalBatch    = 'MembershipRenewalBatch';
	public $WorkflowTrackingID        = 'WorkflowTrackingID';
}

class msReturn extends msAggregate {

	public $CLASS_NAME = 'Return';
	public $ClassType  = 'Return';
	public $Batch      = 'Batch';
	public $Date       = 'Date';
	public $Order      = 'Order';
	public $Reason     = 'Reason';
	public $Comments   = 'Comments';
	public $LineItems  = 'LineItems';
	public $LocalID    = 'LocalID';
}

class msFulfillmentBatch extends msAggregate {

	public $CLASS_NAME = 'FulfillmentBatch';
	public $ClassType  = 'FulfillmentBatch';
	public $IsClosed   = 'IsClosed';
	public $DateClosed = 'DateClosed';
	public $ClosedBy   = 'ClosedBy';
	public $Notes      = 'Notes';
	public $LineItems  = 'LineItems';
	public $LocalID    = 'LocalID';
}

class msFulfillmentBatchLineItem {

	public $CLASS_NAME      = 'FulfillmentBatchLineItem';
	public $ClassType       = 'FulfillmentBatchLineItem';
	public $Order           = 'Order';
	public $OrderLineItemID = 'OrderLineItemID';
	public $QuantityShipped = 'QuantityShipped';
	public $ShippingCarrier = 'ShippingCarrier';
	public $TrackingNumber  = 'TrackingNumber';
}

class msProduct extends msAggregate {

	public $CLASS_NAME                 = 'Product';
	public $ClassType                  = 'Product';
	public $Code                       = 'Code';
	public $IsActive                   = 'IsActive';
	public $BusinessUnit               = 'BusinessUnit';
	public $Category                   = 'Category';
	public $DisplayOrder               = 'DisplayOrder';
	public $Description                = 'Description';
	public $ConfirmationEmail          = 'ConfirmationEmail';
	public $SellOnline                 = 'SellOnline';
	public $SellFrom                   = 'SellFrom';
	public $SellUntil                  = 'SellUntil';
	public $NewUntil                   = 'NewUntil';
	public $Price                      = 'Price';
	public $AllowCustomersToPayLater   = 'AllowCustomersToPayLater';
	public $MemberPrice                = 'MemberPrice';
	public $UseSpecialPricesOnly       = 'UseSpecialPricesOnly';
	public $DisplayPriceAs             = 'DisplayPriceAs';
	public $TrackInventory             = 'TrackInventory';
	public $Weight                     = 'Weight';
	public $AllowBackOrders            = 'AllowBackOrders';
	public $EligibleForShippingCharges = 'EligibleForShippingCharges';
	public $Taxable                    = 'Taxable';
	public $TaxTable                   = 'TaxTable';
	public $ProrationTable             = 'ProrationTable';
	public $SpecialPrices              = 'SpecialPrices';
	public $LinkedProducts             = 'LinkedProducts';
	public $LocalID                    = 'LocalID';
	public $LinkedEntitlements         = 'LinkedEntitlements';
	public $Project                    = 'Project';
	public $ARAccount                  = 'ARAccount';
	public $RevenueAccount             = 'RevenueAccount';
	public $DeferredRevenueAccount     = 'DeferredRevenueAccount';
	public $WriteOffAccount            = 'WriteOffAccount';
	public $InventoryAccount           = 'InventoryAccount';
	public $COGSAccount                = 'COGSAccount';
	public $RevenueSplits              = 'RevenueSplits';
	public $CEUCredits                 = 'CEUCredits';
	public $RevenueRecognitionTemplate = 'RevenueRecognitionTemplate';
	public $Vendor                     = 'Vendor';
	public $BillingTemplate            = 'BillingTemplate';
	public $DefaultWarehouse           = 'DefaultWarehouse';
	public $ShowOnMembershipForm       = 'ShowOnMembershipForm';
	public $Image                      = 'Image';
	public $ReorderPoint               = 'ReorderPoint';
}

class msCustomField extends msAggregate {

	public $CLASS_NAME                = 'CustomField';
	public $ClassType                 = 'CustomField';
	public $ApplicableType            = 'ApplicableType';
	public $FieldDefinition           = 'FieldDefinition';
	public $Type                      = 'Type';
	public $Event                     = 'Event';
	public $Competition               = 'Competition';
	public $Product                   = 'Product';
	public $DisplayOrder              = 'DisplayOrder';
	public $RestrictDisplayBasedOnFee = 'RestrictDisplayBasedOnFee';
	public $ApplicableFees            = 'ApplicableFees';
	public $CustomObject              = 'CustomObject';
	public $SecurityLock              = 'SecurityLock';
}

class msVolunteerTimesheet extends msAggregate {

	public $CLASS_NAME    = 'VolunteerTimesheet';
	public $ClassType     = 'VolunteerTimesheet';
	public $JobAssignment = 'JobAssignment';
	public $HoursWorked   = 'HoursWorked';
	public $StartDate     = 'StartDate';
	public $LocalID       = 'LocalID';
	public $EndDate       = 'EndDate';
	public $Comments      = 'Comments';
}

class msPortalUser extends msUser {

	public $CLASS_NAME     = 'PortalUser';
	public $ClassType      = 'PortalUser';
	public $Owner          = 'Owner';
	public $LastLoggedInAs = 'LastLoggedInAs';
	public $SecurityLock   = 'SecurityLock';
}

class msPackage extends msProduct {

	public $CLASS_NAME = 'Package';
	public $ClassType  = 'Package';
	public $Products   = 'Products';
}

class msPackagedProduct {

	public $CLASS_NAME = 'PackagedProduct';
	public $ClassType  = 'PackagedProduct';
	public $Quantity   = 'Quantity';
	public $Product    = 'Product';
	public $Price      = 'Price';
}

class msInventoryTransaction extends msAggregate {

	public $CLASS_NAME    = 'InventoryTransaction';
	public $ClassType     = 'InventoryTransaction';
	public $Date          = 'Date';
	public $Product       = 'Product';
	public $Warehouse     = 'Warehouse';
	public $Quantity      = 'Quantity';
	public $InvoiceNumber = 'InvoiceNumber';
	public $Notes         = 'Notes';
}

class msInventoryReceipt extends msInventoryTransaction {

	public $CLASS_NAME            = 'InventoryReceipt';
	public $ClassType             = 'InventoryReceipt';
	public $StartingQuantity      = 'StartingQuantity';
	public $EndingQuantity        = 'EndingQuantity';
	public $COGSQuantityRemaining = 'COGSQuantityRemaining';
	public $UnitCost              = 'UnitCost';
}

class msInventoryAdjustment extends msInventoryTransaction {

	public $CLASS_NAME = 'InventoryAdjustment';
	public $ClassType  = 'InventoryAdjustment';
}

class msOrderRelatedInventoryTransaction extends msInventoryTransaction {

	public $CLASS_NAME      = 'OrderRelatedInventoryTransaction';
	public $ClassType       = 'OrderRelatedInventoryTransaction';
	public $Order           = 'Order';
	public $OrderLineItemID = 'OrderLineItemID';
}

class msInventoryBackorder extends msOrderRelatedInventoryTransaction {

	public $CLASS_NAME = 'InventoryBackorder';
	public $ClassType  = 'InventoryBackorder';
}

class msInventoryReservation extends msInventoryTransaction {

	public $CLASS_NAME = 'InventoryReservation';
	public $ClassType  = 'InventoryReservation';
}

class msExpiringProduct extends msProduct {

	public $CLASS_NAME                 = 'ExpiringProduct';
	public $ClassType                  = 'ExpiringProduct';
	public $ExpirationType             = 'ExpirationType';
	public $Availability               = 'Availability';
	public $StartDate                  = 'StartDate';
	public $SellForNextYearAfter       = 'SellForNextYearAfter';
	public $SetDatesBasedOnPaymentDate = 'SetDatesBasedOnPaymentDate';
	public $SellForNextMonthAfterDay   = 'SellForNextMonthAfterDay';
	public $StartDay                   = 'StartDay';
	public $TermLength                 = 'TermLength';
	public $UpdateDatesWhen            = 'UpdateDatesWhen';
	public $RequiresApproval           = 'RequiresApproval';
	public $RenewalTerms               = 'RenewalTerms';
	public $ProFormaRenewalInvoices    = 'ProFormaRenewalInvoices';
	public $GracePeriod                = 'GracePeriod';
	public $InvoicePercentage          = 'InvoicePercentage';
	public $AutoRenew                  = 'AutoRenew';
}

class msTask extends msAggregate {

	public $CLASS_NAME   = 'Task';
	public $ClassType    = 'Task';
	public $Description  = 'Description';
	public $DueDate      = 'DueDate';
	public $Status       = 'Status';
	public $Owner        = 'Owner';
	public $SecurityLock = 'SecurityLock';
}

class msMetadataContainer extends msAggregate {

	public $CLASS_NAME     = 'MetadataContainer';
	public $ClassType      = 'MetadataContainer';
	public $IsDefault      = 'IsDefault';
	public $CustomObject   = 'CustomObject';
	public $Description    = 'Description';
	public $ApplicableType = 'ApplicableType';
}

class msForum extends msAggregate {

	public $CLASS_NAME      = 'Forum';
	public $ClassType       = 'Forum';
	public $DisplayOrder    = 'DisplayOrder';
	public $DiscussionBoard = 'DiscussionBoard';
	public $Description     = 'Description';
	public $GroupName       = 'GroupName';
	public $MembersOnly     = 'MembersOnly';
	public $Moderated       = 'Moderated';
	public $IsActive        = 'IsActive';
}

class msInsertionOrderInvoiceBatch extends msAggregate {

	public $CLASS_NAME                 = 'InsertionOrderInvoiceBatch';
	public $ClassType                  = 'InsertionOrderInvoiceBatch';
	public $Issue                      = 'Issue';
	public $Terms                      = 'Terms';
	public $AutomaticallyEmailInvoices = 'AutomaticallyEmailInvoices';
	public $Status                     = 'Status';
	public $CompletionDate             = 'CompletionDate';
	public $SearchToUse                = 'SearchToUse';
	public $InvoiceBatch               = 'InvoiceBatch';
}

class msFund extends msAggregate {

	public $CLASS_NAME   = 'Fund';
	public $ClassType    = 'Fund';
	public $BusinessUnit = 'BusinessUnit';
	public $Code         = 'Code';
	public $Description  = 'Description';
	public $StartDate    = 'StartDate';
	public $EndDate      = 'EndDate';
	public $Goal         = 'Goal';
	public $Notes        = 'Notes';
	public $GLAccounts   = 'GLAccounts';
	public $Premiums     = 'Premiums';
	public $IsActive     = 'IsActive';
	public $SecurityLock = 'SecurityLock';
}

class CreditCard {

	public $NameOnCard;
	public $CardNumber;
	public $CardExpirationDate;
	public $BillingAddress;
	public $CCVCode;
}

class msInvoiceAdjustment extends msBatchMember {

	public $CLASS_NAME = 'InvoiceAdjustment';
	public $ClassType  = 'InvoiceAdjustment';
	public $Invoice    = 'Invoice';
	public $Total      = 'Total';
	public $LineItems  = 'LineItems';
}

class PaymentAdjustmentInstruction {

	public $PaymentLineItemID;
	public $PaymentID;
	public $InvoiceAdjustmentPaymentAction;
	public $Amount;
}

class msPaymentLineItem {

	public $CLASS_NAME = 'PaymentLineItem';
	public $ClassType  = 'PaymentLineItem';
	public $Type       = 'Type';
	public $Credit     = 'Credit';
	public $Invoice    = 'Invoice';
	public $Amount     = 'Amount';
}

class msRevenueRecognitionSchedule extends msFinancialSchedule {

	public $CLASS_NAME        = 'RevenueRecognitionSchedule';
	public $ClassType         = 'RevenueRecognitionSchedule';
	public $Entries           = 'Entries';
	public $BusinessUnit      = 'BusinessUnit';
	public $Invoice           = 'Invoice';
	public $InvoiceLineItemID = 'InvoiceLineItemID';
}

class msBillingSchedule extends msFinancialSchedule {

	public $CLASS_NAME      = 'BillingSchedule';
	public $ClassType       = 'BillingSchedule';
	public $Entries         = 'Entries';
	public $Status          = 'Status';
	public $OrderLineItemID = 'OrderLineItemID';
	public $Order           = 'Order';
	public $Notes           = 'Notes';
}

class msJob extends msAggregate {

	public $CLASS_NAME        = 'Job';
	public $ClassType         = 'Job';
	public $Description       = 'Description';
	public $Context           = 'Context';
	public $Status            = 'Status';
	public $DateStarted       = 'DateStarted';
	public $DateCompleted     = 'DateCompleted';
	public $Log               = 'Log';
	public $ConfirmationEmail = 'ConfirmationEmail';
	public $LocalID           = 'LocalID';
}

class msMembershipRenewalJob extends msJob {

	public $CLASS_NAME    = 'MembershipRenewalJob';
	public $ClassType     = 'MembershipRenewalJob';
	public $SendOutEmails = 'SendOutEmails';
}

class msCustomJob extends msJob {

	public $CLASS_NAME = 'CustomJob';
	public $ClassType  = 'CustomJob';
}

class msLegislativeTerm extends msAggregate {

	public $CLASS_NAME      = 'LegislativeTerm';
	public $ClassType       = 'LegislativeTerm';
	public $LegislativeBody = 'LegislativeBody';
	public $StartDate       = 'StartDate';
	public $EndDate         = 'EndDate';
	public $Description     = 'Description';
	public $SecurityLock    = 'SecurityLock';
}

class msExhibitor extends msAggregate {

	public $CLASS_NAME           = 'Exhibitor';
	public $ClassType            = 'Exhibitor';
	public $Show                 = 'Show';
	public $Status               = 'Status';
	public $Customer             = 'Customer';
	public $RegistrationWindow   = 'RegistrationWindow';
	public $ContractSendDate     = 'ContractSendDate';
	public $ContractReceivedDate = 'ContractReceivedDate';
	public $CancellationDate     = 'CancellationDate';
	public $Notes                = 'Notes';
	public $Booths               = 'Booths';
	public $BoothPreferences     = 'BoothPreferences';
	public $Contacts             = 'Contacts';
	public $BoothTypes           = 'BoothTypes';
	public $Logo                 = 'Logo';
	public $Bio                  = 'Bio';
	public $Order                = 'Order';
	public $OrderLineItemID      = 'OrderLineItemID';
}

class msSalesOrderLineItem {

	public $CLASS_NAME  = 'SalesOrderLineItem';
	public $ClassType   = 'SalesOrderLineItem';
	public $Product     = 'Product';
	public $Quantity    = 'Quantity';
	public $UnitPrice   = 'UnitPrice';
	public $Description = 'Description';
	public $Total       = 'Total';
}

class msMembershipLeader {

	public $CLASS_NAME              = 'MembershipLeader';
	public $ClassType               = 'MembershipLeader';
	public $Individual              = 'Individual';
	public $CanCreateMembers        = 'CanCreateMembers';
	public $CanDownloadRoster       = 'CanDownloadRoster';
	public $CanMakePayments         = 'CanMakePayments';
	public $CanManageCommittees     = 'CanManageCommittees';
	public $CanManageEvents         = 'CanManageEvents';
	public $CanManageLeaders        = 'CanManageLeaders';
	public $CanUpdateContactInfo    = 'CanUpdateContactInfo';
	public $CanUpdateInformation    = 'CanUpdateInformation';
	public $CanUpdateMembershipInfo = 'CanUpdateMembershipInfo';
	public $CanViewAccountHistory   = 'CanViewAccountHistory';
	public $CanViewMembers          = 'CanViewMembers';
	public $CanLoginAs              = 'CanLoginAs';
	public $CanManageDocuments      = 'CanManageDocuments';
	public $CanModerateDiscussions  = 'CanModerateDiscussions';
}

class msFundraisingProduct extends msProduct {

	public $CLASS_NAME  = 'FundraisingProduct';
	public $ClassType   = 'FundraisingProduct';
	public $Campaign    = 'Campaign';
	public $Appeal      = 'Appeal';
	public $GiftSubType = 'GiftSubType';
	public $Fund        = 'Fund';
}

class msRegistrationBase extends msAggregate {

	public $CLASS_NAME             = 'RegistrationBase';
	public $ClassType              = 'RegistrationBase';
	public $Order                  = 'Order';
	public $OrderLineItemID        = 'OrderLineItemID';
	public $Fee                    = 'Fee';
	public $Event                  = 'Event';
	public $Approved               = 'Approved';
	public $Notes                  = 'Notes';
	public $DateApproved           = 'DateApproved';
	public $HasGeneratedCEUCredits = 'HasGeneratedCEUCredits';
	public $Owner                  = 'Owner';
	public $CheckInDate            = 'CheckInDate';
	public $AssignedTo             = 'AssignedTo';
	public $OnWaitList             = 'OnWaitList';
	public $CancellationDate       = 'CancellationDate';
	public $CancellationReason     = 'CancellationReason';
	public $Group;
}

class msCertification extends msAggregate {

	public $ClassType           = 'Certification';
	public $Certificant         = 'Certificant';
	public $Program             = 'Program';
	public $Status              = 'Status';
	public $StatusReason        = 'StatusReason';
	public $Certified           = 'Certified';
	public $RequirementsMet     = 'RequirementsMet';
	public $PaidThruDate        = 'PaidThruDate';
	public $RecertificationDate = 'RecertificationDate';
	public $CertificationDate   = 'CertificationDate';
	public $ApplicationDate     = 'ApplicationDate';
	public $EffectiveDate       = 'EffectiveDate';
	public $ExpirationDate      = 'ExpirationDate';
	public $CertificateSentDate = 'CertificateSentDate';
	public $EnrollmentDate      = 'EnrollmentDate';
	public $TerminationDate     = 'TerminationDate';
	public $Notes               = 'Notes';
	public $CEUGracePeriod      = 'CEUGracePeriod';
}

class msCertificationProgram extends msAggregate {

	public $CLASS_NAME                 = 'CertificationProgram';
	public $ClassType                  = 'CertificationProgram';
	public $Code                       = 'Code';
	public $Type                       = 'Type';
	public $Description                = 'Description';
	public $Term                       = 'Term';
	public $Designation                = 'Designation';
	public $RenewalProgram             = 'RenewalProgram';
	public $AwardDesignation           = 'AwardDesignation';
	public $MembersOnly                = 'MembersOnly';
	public $RecommendationRequirements = 'RecommendationRequirements';
	public $CEURequirements            = 'CEURequirements';
	public $ExamRequirements           = 'ExamRequirements';
}

class msAwardRecipient extends msAggregate {

	public $CLASS_NAME       = 'AwardRecipient';
	public $ClassType        = 'AwardRecipient';
	public $Award            = 'Award';
	public $Recipient        = 'Recipient';
	public $Period           = 'Period';
	public $Date             = 'Date';
	public $Status           = 'Status';
	public $CompetitionEntry = 'CompetitionEntry';
	public $Notes            = 'Notes';
}

class msChapter extends msAggregate {

	public $CLASS_NAME                      = 'Chapter';
	public $ClassType                       = 'Chapter';
	public $Code                            = 'Code';
	public $IsActive                        = 'IsActive';
	public $MembershipOrganization          = 'MembershipOrganization';
	public $Type                            = 'Type';
	public $LinkedOrganization              = 'LinkedOrganization';
	public $Layer                           = 'Layer';
	public $Description                     = 'Description';
	public $EmailAddress                    = 'EmailAddress';
	public $Url                             = 'Url';
	public $NewMemberConfirmationEmail      = 'NewMemberConfirmationEmail';
	public $RenewingMemberConfirmationEmail = 'RenewingMemberConfirmationEmail';
	public $Leaders                         = 'Leaders';
	public $LocalID;
}

class msExhibitorContactRestriction extends msAggregate {

	public $CLASS_NAME              = 'ExhibitorContactRestriction';
	public $ClassType               = 'ExhibitorContactRestriction';
	public $Show                    = 'Show';
	public $EvaluationOrder         = 'EvaluationOrder';
	public $ContactType             = 'ContactType';
	public $PriorityPointMinimum    = 'PriorityPointMinimum';
	public $PriorityPointMaximum    = 'PriorityPointMaximum';
	public $SquareFootageMinimum    = 'SquareFootageMinimum';
	public $SquareFootageMaximum    = 'SquareFootageMaximum';
	public $MaximumNumberOfContacts = 'MaximumNumberOfContacts';
	public $BoothCategory           = 'BoothCategory';
	public $BoothType               = 'BoothType';
	public $ErrorMessage            = 'ErrorMessage';
	public $Notes                   = 'Notes';
}

class msAdvertisingContract extends msAggregate {

	public $CLASS_NAME         = 'AdvertisingContract';
	public $ClassType          = 'AdvertisingContract';
	public $Publication        = 'Publication';
	public $Agency             = 'Agency';
	public $Advertiser         = 'Advertiser';
	public $BillTo             = 'BillTo';
	public $BillingAddress     = 'BillingAddress';
	public $RateCard           = 'RateCard';
	public $ContactName        = 'ContactName';
	public $ContactPhone       = 'ContactPhone';
	public $ContactEmail       = 'ContactEmail';
	public $SignatureDate      = 'SignatureDate';
	public $ReceivedDate       = 'ReceivedDate';
	public $TermStart          = 'TermStart';
	public $TermEnd            = 'TermEnd';
	public $NumberOfPlacements = 'NumberOfPlacements';
	public $Notes              = 'Notes';
	public $LocalID;
}

class msSubscription extends msAggregate {

	public $CLASS_NAME                 = 'Subscription';
	public $ClassType                  = 'Subscription';
	public $Publication                = 'Publication';
	public $Fee                        = 'Fee';
	public $Address                    = 'Address';
	public $OriginalOrder              = 'OriginalOrder';
	public $OriginalOrderLineItemID    = 'OriginalOrderLineItemID';
	public $LastOrder                  = 'LastOrder';
	public $LastOrderLineItemID        = 'LastOrderLineItemID';
	public $Owner                      = 'Owner';
	public $OnHold                     = 'OnHold';
	public $OverrideShipToAddress      = 'OverrideShipToAddress';
	public $OverrideShipToName         = 'OverrideShipToName';
	public $StartDate                  = 'StartDate';
	public $TerminationDate            = 'TerminationDate';
	public $TerminationReason          = 'TerminationReason';
	public $ExpirationDate             = 'ExpirationDate';
	public $Notes                      = 'Notes';
	public $DoNotRenew                 = 'DoNotRenew';
	public $AutomaticallyPayForRenewal = 'AutomaticallyPayForRenewal';
}

class msDiscountCode extends msAggregate {

	public $CLASS_NAME                       = 'DiscountCode';
	public $ClassType                        = 'DiscountCode';
	public $Code                             = 'Code';
	public $Description                      = 'Description';
	public $ValidFrom                        = 'ValidFrom';
	public $ValidUntil                       = 'ValidUntil';
	public $ApplicableProducts               = 'ApplicableProducts';
	public $ApplicableProductTypes           = 'ApplicableProductTypes';
	public $ApplicableProductCategories      = 'ApplicableProductCategories';
	public $MaximumNumberOfUsages            = 'MaximumNumberOfUsages';
	public $MaximumNumberOfUsagesPerCustomer = 'MaximumNumberOfUsagesPerCustomer';
	public $EligibleCustomers                = 'EligibleCustomers';
	public $RestrictToEligibleProducts       = 'RestrictToEligibleProducts';
	public $RestrictToSpecifiedCustomers     = 'RestrictToSpecifiedCustomers';
	public $Amount                           = 'Amount';
	public $Percentage                       = 'Percentage';
	public $DiscountProduct                  = 'DiscountProduct';
}

class msMiscellaneousProduct extends msProduct {

	public $CLASS_NAME = 'MiscellaneousProduct';
	public $ClassType  = 'MiscellaneousProduct';
}

class msAccountingProject extends msAggregate {

	public $CLASS_NAME   = 'AccountingProject';
	public $ClassType    = 'AccountingProject';
	public $Description  = 'Description';
	public $BusinessUnit = 'BusinessUnit';
	public $Code         = 'Code';
	public $EndDate      = 'EndDate';
	public $IsActive     = 'IsActive';
}

class msDiscussionTopic extends msAggregate {

	public $CLASS_NAME = 'DiscussionTopic';
	public $ClassType  = 'DiscussionTopic';
	public $Forum      = 'Forum';
	public $PostedBy   = 'PostedBy';
}

class msSearchEntitlement extends msEntitlement {

	public $CLASS_NAME = 'SearchEntitlement';
	public $ClassType  = 'SearchEntitlement';
	public $Search     = 'Search';
}

class msFinancialSchedule extends msAggregate {

	public $CLASS_NAME   = 'FinancialSchedule';
	public $ClassType    = 'FinancialSchedule';
	public $IsSuspended  = 'IsSuspended';
	public $SecurityLock = 'SecurityLock';
}


class msFinancialScheduleEntry {

	public $CLASS_NAME    = 'FinancialScheduleEntry';
	public $ClassType     = 'FinancialScheduleEntry';
	public $EntryID       = 'EntryID';
	public $DateProcessed = 'DateProcessed';
	public $Date          = 'Date';
	public $Amount        = 'Amount';
}

class msBillingScheduleEntry extends msFinancialScheduleEntry {

	public $CLASS_NAME  = 'BillingScheduleEntry';
	public $ClassType   = 'BillingScheduleEntry';
	public $Status      = 'Status';
	public $IsPerpetual = 'IsPerpetual';
	public $Message     = 'Message';
	public $Invoice     = 'Invoice';
	public $Payment     = 'Payment';
}

class msVolunteerJobAssignment extends msAggregate {

	public $CLASS_NAME    = 'VolunteerJobAssignment';
	public $ClassType     = 'VolunteerJobAssignment';
	public $JobOccurrence = 'JobOccurrence';
	public $Volunteer     = 'Volunteer';
	public $StartDateTime = 'StartDateTime';
	public $EndDateTime   = 'EndDateTime';
	public $Comments      = 'Comments';
	public $LocalID       = 'LocalID';
}

class msPortalControlPropertyOverride extends msAggregate {

	public $CLASS_NAME   = 'PortalControlPropertyOverride';
	public $ClassType    = 'PortalControlPropertyOverride';
	public $PageName     = 'PageName';
	public $ControlName  = 'ControlName';
	public $PropertyName = 'PropertyName';
	public $Value        = 'Value';
	public $Description  = 'Description';
}

class msPortalPageLayoutContainer extends msMetadataContainer {

	public $CLASS_NAME = 'PortalPageLayoutContainer';
	public $ClassType  = 'PortalPageLayoutContainer';
	public $Metadata   = 'Metadata';
}

class msData360PageLayoutContainer extends msMetadataContainer {

	public $CLASS_NAME = 'Data360PageLayoutContainer';
	public $ClassType  = 'Data360PageLayoutContainer';
	public $Metadata   = 'Metadata';
}

class msDataEntryPageLayoutContainer extends msMetadataContainer {

	public $CLASS_NAME = 'DataEntryPageLayoutContainer';
	public $ClassType  = 'DataEntryPageLayoutContainer';
	public $Metadata   = 'Metadata';
}

class msUserPreferencesContainer extends msAggregate {

	public $CLASS_NAME  = 'UserPreferencesContainer';
	public $ClassType   = 'UserPreferencesContainer';
	public $User        = 'User';
	public $RecentItems = 'RecentItems';
	public $Favorites   = 'Favorites';
	public $Preferences = 'Preferences';
}

class msConsoleMetadataContainer extends msMetadataContainer {

	public $CLASS_NAME = 'ConsoleMetadataContainer';
	public $ClassType  = 'ConsoleMetadataContainer';
	public $Metadata   = 'Metadata';
}

class msIntegrationLink extends msAggregate {

	public $CLASS_NAME      = 'IntegrationLink';
	public $ClassType       = 'IntegrationLink';
	public $Type            = 'Type';
	public $TargetGroup     = 'TargetGroup';
	public $Display         = 'Display';
	public $TargetName      = 'TargetName';
	public $Description     = 'Description';
	public $Link            = 'Link';
	public $DisplayCriteria = 'DisplayCriteria';
	public $PostLoginToken  = 'PostLoginToken';
}

class msActivity extends msAggregate {

	public $CLASS_NAME             = 'Activity';
	public $ClassType              = 'Activity';
	public $Type                   = 'Type';
	public $Status                 = 'Status';
	public $Owner                  = 'Owner';
	public $Entity                 = 'Entity';
	public $Bill                   = 'Bill';
	public $Legislator             = 'Legislator';
	public $Accreditation          = 'Accreditation';
	public $AccreditationAppeal    = 'AccreditationAppeal';
	public $AccreditationSiteVisit = 'AccreditationSiteVisit';
	public $Lead                   = 'Lead';
	public $Request                = 'Request';
	public $Gift                   = 'Gift';
	public $Date                   = 'Date';
	public $Description            = 'Description';
	public $Opportunity            = 'Opportunity';
}

class msInvoiceTerms extends msAggregate {

	public $CLASS_NAME   = 'InvoiceTerms';
	public $ClassType    = 'InvoiceTerms';
	public $NumberOfDays = 'NumberOfDays';
	public $IsDefault    = 'IsDefault';
	public $IsActive;
}

class msLead extends msAggregate {

	public $CLASS_NAME    = 'Lead';
	public $ClassType     = 'Lead';
	public $Owner         = 'Owner';
	public $FirstName     = 'FirstName';
	public $LastName      = 'LastName';
	public $Organization  = 'Organization';
	public $Title         = 'Title';
	public $Phone         = 'Phone';
	public $Status        = 'Status';
	public $Type          = 'Type';
	public $Email         = 'Email';
	public $AnnualRevenue = 'AnnualRevenue';
	public $Address       = 'Address';
	public $Description   = 'Description';
	public $DateConverted = 'DateConverted';
	public $Opportunity   = 'Opportunity';
	public $Account       = 'Account';
	public $Contact       = 'Contact';
	public $Campaigns     = 'Campaigns';
	public $LocalID       = 'LocalID';
}

class msVolunteer extends msAggregate {

	public $CLASS_NAME            = 'Volunteer';
	public $ClassType             = 'Volunteer';
	public $Types                 = 'Types';
	public $Individual            = 'Individual';
	public $EmergencyContactName  = 'EmergencyContactName';
	public $EmergencyContactPhone = 'EmergencyContactPhone';
	public $Sponsor               = 'Sponsor';
	public $Traits                = 'Traits';
	public $Availability          = 'Availability';
	public $Locations             = 'Locations';
	public $AvailabilityComment   = 'AvailabilityComment';
	public $UnavailableFrom       = 'UnavailableFrom';
	public $UnavailableTo         = 'UnavailableTo';
}

class msVolunteerAssignedType {

	public $CLASS_NAME = 'VolunteerAssignedType';
	public $ClassType  = 'VolunteerAssignedType';
	public $Type       = 'Type';
	public $StartDate  = 'StartDate';
	public $EndDate    = 'EndDate';
	public $Status     = 'Status';
}

class msVolunteerAvailability {

	public $CLASS_NAME = 'VolunteerAvailability';
	public $ClassType  = 'VolunteerAvailability';
	public $StartDate  = 'StartDate';
	public $EndDate    = 'EndDate';
	public $DaysOfWeek = 'DaysOfWeek';
	public $StartTime  = 'StartTime';
	public $EndTime    = 'EndTime';
}

class msResume extends msAggregate {

	public $CLASS_NAME = 'Resume';
	public $ClassType  = 'Resume';
	public $Owner      = 'Owner';
	public $File       = 'File';
	public $IsActive   = 'IsActive';
	public $IsApproved = 'IsApproved';
	public $LocalID    = 'LocalID';
}

class msMerchantAccount extends msAggregate {

	public $CLASS_NAME          = 'MerchantAccount';
	public $ClassType           = 'MerchantAccount';
	public $Description         = 'Description';
	public $BusinessUnit        = 'BusinessUnit';
	public $CashAccount         = 'CashAccount';
	public $IsDefault           = 'IsDefault';
	public $DefaultBatch        = 'DefaultBatch';
	public $CutOffHour          = 'CutOffHour';
	public $IsExternalAccount   = 'IsExternalAccount';
	public $Chapter             = 'Chapter';
	public $OrganizationalLayer = 'OrganizationalLayer';
	public $Section             = 'Section';
	public $LocalID             = 'LocalID';
}

class msPayPalMerchantAccount extends msMerchantAccount {

	public $CLASS_NAME   = 'PayPalMerchantAccount';
	public $ClassType    = 'PayPalMerchantAccount';
	public $UserName     = 'UserName';
	public $Password     = 'Password';
	public $APISignature = 'APISignature';
}

class msAuthorizeNetMerchantAccount extends msMerchantAccount {

	public $CLASS_NAME      = 'AuthorizeNetMerchantAccount';
	public $ClassType       = 'AuthorizeNetMerchantAccount';
	public $MerchantLoginID = 'MerchantLoginID';
	public $TransactionKey  = 'TransactionKey';
}

class msPayFlowProMerchantAccount extends msMerchantAccount {

	public $CLASS_NAME      = 'PayFlowProMerchantAccount';
	public $ClassType       = 'PayFlowProMerchantAccount';
	public $MerchantLoginID = 'MerchantLoginID';
	public $Partner         = 'Partner';
	public $Password        = 'Password';
}

class msAgency extends msAggregate {

	public $CLASS_NAME   = 'Agency';
	public $ClassType    = 'Agency';
	public $Organization = 'Organization';
	public $Notes        = 'Notes';
	public $Discount     = 'Discount';
	public $LocalID      = 'LocalID';
}

class msLegacyProduct extends msProduct {

	public $CLASS_NAME = 'LegacyProduct';
	public $ClassType  = 'LegacyProduct';
}

class msHistoricalTransaction extends msAggregate {

	public $CLASS_NAME      = 'HistoricalTransaction';
	public $ClassType       = 'HistoricalTransaction';
	public $Date            = 'Date';
	public $Type            = 'Type';
	public $Memo            = 'Memo';
	public $Owner           = 'Owner';
	public $Order           = 'Order';
	public $Total           = 'Total';
	public $LineItems       = 'LineItems';
	public $ReferenceNumber = 'ReferenceNumber';
	public $Notes           = 'Notes';
	public $LocalID         = 'LocalID';
}

class msHistoricalTransactionLineItem {

	public $CLASS_NAME  = 'HistoricalTransactionLineItem';
	public $ClassType   = 'HistoricalTransactionLineItem';
	public $Quantity    = 'Quantity';
	public $UnitPrice   = 'UnitPrice';
	public $Description = 'Description';
	public $Total       = 'Total';
}

class msBillingTemplate extends msAggregate {

	public $CLASS_NAME                   = 'BillingTemplate';
	public $ClassType                    = 'BillingTemplate';
	public $Description                  = 'Description';
	public $GenerateEntireInvoiceUpFront = 'GenerateEntireInvoiceUpFront';
	public $RecurrenceTemplate           = 'RecurrenceTemplate';
	public $LocalID                      = 'LocalID';
}

class msPortalForm extends msAggregate {

	public $CLASS_NAME                 = 'PortalForm';
	public $ClassType                  = 'PortalForm';
	public $DisplayOrder               = 'DisplayOrder';
	public $LoginScreenDisplayName     = 'LoginScreenDisplayName';
	public $DisplayOnHomeScreen        = 'DisplayOnHomeScreen';
	public $HomeScreenDisplayName      = 'HomeScreenDisplayName';
	public $CustomerType               = 'CustomerType';
	public $Module                     = 'Module';
	public $Description                = 'Description';
	public $ShowFrom                   = 'ShowFrom';
	public $ShowUntil                  = 'ShowUntil';
	public $MembersOnly                = 'MembersOnly';
	public $DisplayOnLoginScreen       = 'DisplayOnLoginScreen';
	public $ConfirmationEmail          = 'ConfirmationEmail';
	public $FormInstructions           = 'FormInstructions';
	public $EditInstructions           = 'EditInstructions';
	public $ConfirmationInstructions   = 'ConfirmationInstructions';
	public $ViewInstructions           = 'ViewInstructions';
	public $ManageInstructions         = 'ManageInstructions';
	public $PostSubmissionInstructions = 'PostSubmissionInstructions';
	public $CreatePageLayout           = 'CreatePageLayout';
	public $EditPageLayout             = 'EditPageLayout';
	public $ViewPageLayout             = 'ViewPageLayout';
	public $ActivityType               = 'ActivityType';
	public $ValueAssignments           = 'ValueAssignments';
	public $LocalID                    = 'LocalID';
}

class msPortalFormValueAssignment {

	public $CLASS_NAME           = 'PortalFormValueAssignment';
	public $ClassType            = 'PortalFormValueAssignment';
	public $FieldName            = 'FieldName';
	public $ValueToSet           = 'ValueToSet';
	public $OnlyIfPreviouslyNull = 'OnlyIfPreviouslyNull';
	public $ClearExistingValues  = 'ClearExistingValues';
}

class msCustomObjectPortalForm extends msPortalForm {

	public $CLASS_NAME                       = 'CustomObjectPortalForm';
	public $ClassType                        = 'CustomObjectPortalForm';
	public $CustomObject                     = 'CustomObject';
	public $MaximumNumberOfSubmissions       = 'MaximumNumberOfSubmissions';
	public $AccessMode                       = 'AccessMode';
	public $FormSubmissionManagementLinkText = 'FormSubmissionManagementLinkText';
	public $ManagementFieldsToDisplay        = 'ManagementFieldsToDisplay';
	public $AllowAnonymousSubmissions        = 'AllowAnonymousSubmissions';
	public $AnonymousSubmissionCompletionUrl = 'AnonymousSubmissionCompletionUrl';
}

class msProrationTable extends msAggregate {

	public $CLASS_NAME  = 'ProrationTable';
	public $ClassType   = 'ProrationTable';
	public $Description = 'Description';
	public $Entries     = 'Entries';
}

class msProrationTableEntry {

	public $CLASS_NAME = 'ProrationTableEntry';
	public $ClassType  = 'ProrationTableEntry';
	public $StartDate  = 'StartDate';
	public $EndDate    = 'EndDate';
	public $Proration  = 'Proration';
}

class msConfigurableType extends msAggregate {

	public $CLASS_NAME   = 'ConfigurableType';
	public $ClassType    = 'ConfigurableType';
	public $Description  = 'Description';
	public $Code         = 'Code';
	public $DisplayOrder = 'DisplayOrder';
	public $IsDefault    = 'IsDefault';
}

class msPageLayoutConfigurableType extends msConfigurableType {

	public $CLASS_NAME       = 'PageLayoutConfigurableType';
	public $ClassType        = 'PageLayoutConfigurableType';
	public $CreatePageLayout = 'CreatePageLayout';
	public $EditPageLayout   = 'EditPageLayout';
	public $ViewPageLayout   = 'ViewPageLayout';
	public $PortalPageLayout = 'PortalPageLayout';
}

class msReturnReason extends msConfigurableType {

	public $CLASS_NAME = 'ReturnReason';
	public $ClassType  = 'ReturnReason';
}

class DuplicateField {

	public $Name;
	public $DuplicateDetectionMatchMode;// 0,1,2
}

class msAssociationConfigurationContainer extends msAggregate {

	public $CLASS_NAME                              = 'AssociationConfigurationContainer';
	public $ClassType                               = 'AssociationConfigurationContainer';
	public $ConfigurationValues                     = 'ConfigurationValues';
	public $DisplayAddress                          = 'DisplayAddress';
	public $EnableApiAccess                         = 'EnableApiAccess';
	public $Mode                                    = 'Mode';
	public $Acronym                                 = 'Acronym';
	public $Address                                 = 'Address';
	public $Logo                                    = 'Logo';
	public $WriteOffMethod                          = 'WriteOffMethod';
	public $AccountingMethod                        = 'AccountingMethod';
	public $FinancialSoftwarePackage                = 'FinancialSoftwarePackage';
	public $BatchDownloadMethod                     = 'BatchDownloadMethod';
	public $InvoiceReport                           = 'InvoiceReport';
	public $PaymentReceiptReport                    = 'PaymentReceiptReport';
	public $OrderReceiptReport                      = 'OrderReceiptReport';
	public $VerifyControlValuesWhenPostingBatches   = 'VerifyControlValuesWhenPostingBatches';
	public $PortalHeaderGraphic                     = 'PortalHeaderGraphic';
	public $PortalSkin                              = 'PortalSkin';
	public $PortalLoginScreenText                   = 'PortalLoginScreenText';
	public $PortalDisplayBecomeMember               = 'PortalDisplayBecomeMember';
	public $PortalDisplayMakeDonation               = 'PortalDisplayMakeDonation';
	public $PortalAdditionalLinks                   = 'PortalAdditionalLinks';
	public $ShowUpcomingEventsTabInPortal           = 'ShowUpcomingEventsTabInPortal';
	public $SendEmailWhenUserUpdatesInformation     = 'SendEmailWhenUserUpdatesInformation';
	public $PortalDisplayCreateUserAccount          = 'PortalDisplayCreateUserAccount';
	public $AssociationHomePageUrl                  = 'AssociationHomePageUrl';
	public $MembershipDirectoryEnabled              = 'MembershipDirectoryEnabled';
	public $MembershipDirectoryForMembersOnly       = 'MembershipDirectoryForMembersOnly';
	public $MembershipDirectorySearchFields         = 'MembershipDirectorySearchFields';
	public $MembershipDirectoryTabularResultsFields = 'MembershipDirectoryTabularResultsFields';
	public $MembershipDirectoryDetailsFields        = 'MembershipDirectoryDetailsFields';
	public $PickListReport                          = 'PickListReport';
	public $PackingListReport                       = 'PackingListReport';
	public $OnlineStorefrontEnabled                 = 'OnlineStorefrontEnabled';
	public $IsVerticalResponseEnabled               = 'IsVerticalResponseEnabled';
	public $VerticalResponseUserName                = 'VerticalResponseUserName';
	public $CEUSelfReportingMode                    = 'CEUSelfReportingMode';
	public $ComponentSelfReportingMode              = 'ComponentSelfReportingMode';
	public $ShowCertificationsInPortal              = 'ShowCertificationsInPortal';
	public $ShowComponentRegistrationsInPortal      = 'ShowComponentRegistrationsInPortal';
	public $ShowCEUCreditsInPortal                  = 'ShowCEUCreditsInPortal';
	public $DefaultJobPostingExpiration             = 'DefaultJobPostingExpiration';
	public $JobPostingAccessMode                    = 'JobPostingAccessMode';
	public $ResumeSearchFields                      = 'ResumeSearchFields';
	public $ResumeTabularResultsFields              = 'ResumeTabularResultsFields';
	public $ResumeDetailsFields                     = 'ResumeDetailsFields';
	public $CompetitionEntryDraftStatus             = 'CompetitionEntryDraftStatus';
	public $CompetitionEntryPendingPaymentStatus    = 'CompetitionEntryPendingPaymentStatus';
	public $CompetitionEntrySubmittedStatus         = 'CompetitionEntrySubmittedStatus';
	public $DisableDuplicateCheckConsole            = 'DisableDuplicateCheckConsole';
	public $DisableDuplicateCheckPortal             = 'DisableDuplicateCheckPortal';
	public $PortalCSS                               = 'PortalCSS';
	public $PortalLoginScreenTitle                  = 'PortalLoginScreenTitle';
	public $PortalHideDropShadow                    = 'PortalHideDropShadow';
	public $UseDropDownsForStatesAndCountries       = 'UseDropDownsForStatesAndCountries';
	public $ReorderPointNoficationEmail             = 'ReorderPointNoficationEmail';
}

class ReportManifest {

	public $ReportSpecificationName;
}

class msCatalogAggregate extends msAggregate {

	public $CLASS_NAME = 'CatalogAggregate';
	public $ClassType  = 'CatalogAggregate';
}

class msCustomerDomainObject extends msCatalogAggregate {

	public $CLASS_NAME = 'CustomerDomainObject';
	public $ClassType  = 'CustomerDomainObject';
	public $Customer   = 'Customer';
}

class msAssociation extends msCustomerDomainObject {

	public $CLASS_NAME        = 'Association';
	public $ClassType         = 'Association';
	public $Acronym           = 'Acronym';
	public $DatabaseServer    = 'DatabaseServer';
	public $BaseCurrency      = 'BaseCurrency';
	public $PortalSelfHostUri = 'PortalSelfHostUri';
	public $PortalDisabled    = 'PortalDisabled';
	public $PartitionKey      = 'PartitionKey';
	public $FiscalYearEnd     = 'FiscalYearEnd';
	public $Mode              = 'Mode';
	public $Status            = 'Status';
	public $EnableApiAccess   = 'EnableApiAccess';
	public $TrialEndDate      = 'TrialEndDate';
	public $BillingId         = 'BillingId';
}
