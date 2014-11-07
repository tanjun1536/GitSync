<?php
class MenuModel extends BaseRelationModel {
	protected $_auto = array (array ('code', 'getCode', 1, 'callback' ) );
	protected $_link = array (
			'Menu' => array ('mapping_type' => HAS_MANY, 
					'class_name' => 'Menu',
					 'mapping_name' => 'children',
					 'foreign_key' => 'parent_id',
					 'mapping_order' => 'id asc' ) );
}
?>