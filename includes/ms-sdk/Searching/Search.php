<?php
/*
 Search Object
*/

class Search {

	public $SearchToUse;
	public $Type;
	public $Context;
	public $count;
	public $Module;
	public $Criteria;
	public $OutputColumn;
	public $countoutput;
	public $Sortcolumn;
	public $countsort;
	public $GroupType;
	public $countgroup;

	public function __construct() {
		$this->SearchToUse  = '';
		$this->Type         = '';
		$this->Context      = '';
		$this->count        = 0;
		$this->countoutput  = 0;
		$this->countsort    = 0;
		$this->countgroup   = 0;
		$this->Criteria     = array();
		$this->OutputColumn = array();
		$this->Sortcolumn   = array();
		$this->GroupType    = array();
		$this->Module       = '';
	}

	public function SearchOperationGroupType( $GroupType ) {
		$this->GroupType[ $this->countsort ] = array( 'GroupType' => $GroupType );
		$this->countgroup++;
	}

	public function AddSortColumn( $ColoumnName, $isDescending = 'false' ) {
		$this->Sortcolumn[ $this->countsort ] = array(
			'ColoumnName'  => $ColoumnName,
			'isDescending' => $isDescending,
		);
		$this->countsort++;
	}

	public function AddOutputColumn( $ColoumnName, $Aggregate = 'None' ) {
		$this->OutputColumn[ $this->countoutput ] = array(
			'ColoumnName' => $ColoumnName,
			'Aggregate'   => $Aggregate,
		);
		$this->countoutput++;
	}

	public function AddCriteria( $SearchOperation ) {
		$this->Criteria[ $this->count ] = $SearchOperation;
		$this->count++;
	}
}
