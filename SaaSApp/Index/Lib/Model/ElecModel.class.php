<?php
class ElecModel extends BaseRelationModel {
	protected $_auto = array (array ('requesterdate', 'getDate', 1, 'callback' ), array ('code', 'getCode', 1, 'callback' ) );
	protected $_link = array ('Elecflow' => array ('mapping_type' => HAS_MANY, 'class_name' => 'Elecflow', 'mapping_name' => 'flows', 'foreign_key' => 'elec', 'mapping_order' => 'id asc' ) )
	
	;
	public $viewFields = array ('Elec' => array ('id', 'requester', 'requestername', 'requestercode','requesterdate', 'electype', 'elecchildtype', 'sdate', 'shour', 'sminute', 'edate', 'ehour', 'eminute', 'je', 'descript', 'remark', 'checkersid', 'checkersname', 'atts', 'state', 'nextchecker', 'code' ),
			'Electype' => array ('name' => 'typename', '_on' => 'Elec.electype=Electype.id' )
			,'Elecchildtype' => array ('name' => 'typechildname', '_on' => 'Elec.elecchildtype=Elecchildtype.id' )
	);
}
?>