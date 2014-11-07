<?php
class FormViewModel extends BaseViewModel {
	protected $_auto = array (array ('code', 'getCode', 1, 'callback' ) );
	public $viewFields = array ('Form' => array ('id', 'name', 'type', 'atts', 'code','sendername','senddate' ),
			 'Formtype' => array ('name' => 'typename', '_on' => 'Form.type=Formtype.id' ) );
}
?>