<?php
class FormModel extends BaseModel
{
	protected $_auto = array (array ('code', 'getCode', 1, 'callback' ),
			array ('senderid', 'getId', 1, 'callback' ),
			array ('sendername', 'getName', 1, 'callback' ),array ('senddate', 'getDate', 1, 'callback' )   );
}
?>