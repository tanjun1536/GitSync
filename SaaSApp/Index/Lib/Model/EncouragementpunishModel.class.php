<?php
class EncouragementpunishModel extends BaseModel
{
	protected $_auto = array (array('code','getCode',1,'callback'),
			array('uid','getId',1,'callback'),
			array('uname','getName',1,'callback'), );
}
?>