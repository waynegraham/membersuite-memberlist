<?php
/*
Membersuite Address Object
*/

class Address {

	public $RecordType = 'Address';
	public $CASSCertificationDate;
	public $CarrierRoute;
	public $City;
	public $Company;
	public $CongressionalDistrict;
	public $Country;
	public $County;
	public $DeliveryPointCheckDigit;
	public $DeliveryPointCode;
	public $GeocodeLat;
	public $GeocodeLong;
	public $LastGeocodeDate;
	public $Line1;
	public $Line2;
	public $PostalCode;
	public $State;
}

class EmailTemplate {

	public $SenderID;
	public $DisplayName;
	public $SearchType;
	public $SearchContext;
	public $FromName;
	public $To;
	public $Cc;
	public $Bcc;
	public $Subject;
	public $HtmlBody;
	public $TextBody;
	public $ReplyTo;
}

class ClassMetadataOverride {

	public $Name;
	public $Module;
	public $Createable;
	public $Updateable;
	public $Deletable;
	public $Label;
	public $LabelPlural;
	public $IsAbstract;
	public $IsSecurable;
	public $Fields;// list of fields
	public $ValidationRules;// list validation rules
	public $FieldCalculationRules;// list of calculation rules
}

class ValidationRule {

	public $Name;
	public $Expression;
	public $ErrorMessage;
	public $IsActive;
}

class FieldCalculationRule {

	public $Name;
	public $IsActive;
	public $TargetField;
	public $EvaluationOrder;
	public $Expression;
	public $Criteria;
	public $SkipIfTargetFieldIsSet;
	public $RunOnNewRecordsOnly;
	public $Notes;
}
