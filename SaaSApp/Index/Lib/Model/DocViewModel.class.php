<?php
class DocViewModel extends BaseViewModel {
	protected $_auto = array (array ('senddate', 'getDate', 1, 'callback' ), array ('code', 'getCode', 1, 'callback' ), array ('uid', 'getId', 1, 'callback' ), array ('uname', 'getName', 1, 'callback' ) );
	public $viewFields = array ('Doc' => array ('id', 'uid', 'uname', 'name', 'type', 'atts', 'senddate', 'code' ), 'Doctype' => array ('name' => 'typename', '_on' => 'Doc.type=Doctype.id' ) );
}
?>