<?php
class MsgModel extends BaseModel
{
	protected $_auto = array (
			array('senddate','getDate',1,'callback'),
			array('code','getCode',1,'callback'),
			array('senderid','getId',1,'callback'),
			array('sendername','getName',1,'callback'), );
}
?>