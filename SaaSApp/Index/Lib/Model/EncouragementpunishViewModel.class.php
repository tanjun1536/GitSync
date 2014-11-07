<?php
class EncouragementpunishViewModel extends BaseViewModel {
	protected $_auto = array (array ('code', 'getCode', 1, 'callback' ), array ('uid', 'getId', 1, 'callback' ), array ('uname', 'getName', 1, 'callback' ) );
	public $viewFields = array ('Encouragementpunish' => array ('id', 'code', 'date', 'reason', 'content', 'attachement', 'uid', 'uname' ), 
			'user' => array ('ucode' => 'ucode', '_on' => 'Encouragementpunish.uid=u.id','_as'=>'u' ) );
}
?>