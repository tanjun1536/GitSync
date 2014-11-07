<?php
class ElecchildtypeViewModel extends BaseViewModel {
	public $viewFields = array (
			'Elecchildtype' => array ('id', 'name', 'levels', 'elec', 'hours', 'smoney', 'emoney', 'remark' ), 
			'Electype' => array ('name' => 'pname', '_on' => 'Elecchildtype.elec=Electype.id' ), );
}
?>