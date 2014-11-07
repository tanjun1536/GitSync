<?php
	class UserModel extends BaseRelationModel
	{
		protected $_auto = array (array ('code', 'getCode', 1, 'callback' ) );
		protected $_link = array (
				'Experience' => array (
						'mapping_type' => HAS_MANY,
						'class_name'=>'Experience',
						'mapping_name'=>'experiences',
						'foreign_key' => 'uid',
						'mapping_order'=>'id asc', ),
				'Education' => array (
						'mapping_type' => HAS_MANY,
						'class_name'=>'Education',
						'mapping_name'=>'educations',
						'foreign_key' => 'uid',
						'mapping_order'=>'id asc', ),
				'Skill' => array (
						'mapping_type' => HAS_MANY,
						'class_name'=>'Skill',
						'mapping_name'=>'skills',
						'foreign_key' => 'uid',
						'mapping_order'=>'id asc', ),
				'Family' => array (
						'mapping_type' => HAS_MANY,
						'class_name'=>'Family',
						'mapping_name'=>'families',
						'foreign_key' => 'uid',
						'mapping_order'=>'id asc', ),
				'Certificate' => array (
						'mapping_type' => HAS_MANY,
						'class_name'=>'Certificate',
						'mapping_name'=>'certificates',
						'foreign_key' => 'uid',
						'mapping_order'=>'id asc', ),
				'Duties'=>array('mapping_type'=>HAS_MANY,
					'class_name'=>'Dutydelegate',
					'mapping_name'=>'dutydelegate',
					'foreign_key'=>'uid',
					'mapping_order'=>'id asc'	
						
						),
				
		);
	}
?>