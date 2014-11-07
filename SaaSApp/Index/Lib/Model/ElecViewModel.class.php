<?php
class ElecViewModel extends BaseViewModel {
	protected $_auto = array (array ('code', 'getCode', 1, 'callback' ) );
	public $viewFields = array ('Elec' => array ('id', 'requester', 'requestername', 'requestercode','requesterdate', 'electype', 'elecchildtype', 'sdate', 'shour', 'sminute', 'edate', 'ehour', 'eminute', 'je', 'descript', 'remark', 'checkersid', 'checkersname', 'atts', 'state', 'nextchecker', 'code' ),
			 'Electype' => array ('name' => 'typename', '_on' => 'Elec.electype=Electype.id' )
			 ,'Elecchildtype' => array ('name' => 'typechildname', '_on' => 'Elec.elecchildtype=Elecchildtype.id' )
			 );
}
?>