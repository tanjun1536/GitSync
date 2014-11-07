<?php
class FavoriteModel extends BaseRelationModel {
	protected $_link = array (
			'Favorite' => array ('mapping_type' => HAS_MANY, 
					'class_name' => 'Favorite',
					 'mapping_name' => 'children',
					 'foreign_key' => 'parent',
					 'mapping_order' => 'id asc' ) );
}
?>