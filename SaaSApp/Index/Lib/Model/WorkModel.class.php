<?php
class WorkModel extends BaseModel {
	protected $_auto = array (
			 array ('code', 'getCode', 1, 'callback' ),
			 array ('uid', 'getId', 1, 'callback' ), 
			array ('uname', 'getName', 1, 'callback' ) );
	public $viewFields = array (
			'Work' => array ('id', 'code', 'date', 'remark', 'status', 'uid', 'ucode', 'shour', 'sminute', 'ehour', 'eminute', 'type', 'description', 'awoke' )
			,'User'=>array('ucode'=>'ucode','name'=>'uname','_on'=>'Work.uid=User.id'),
			'Depart'=>array('id'=>'depart','_on'=>'User.depart=Depart.id')
			);
}
?>