<?php
class CheckModel extends BaseModel {
	protected $_auto = array (
			array ('code', 'getCode', 1, 'callback' ),
			array ('date', 'getDate', 1, 'callback' ),
			);
}
?>