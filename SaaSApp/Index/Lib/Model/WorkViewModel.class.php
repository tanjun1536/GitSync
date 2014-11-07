<?php
	class WorkViewModel extends BaseViewModel
	{
		protected $_auto = array (array ('date', 'getDate', 1, 'callback' ), array ('code', 'getCode', 1, 'callback' ), array ('uid', 'getId', 1, 'callback' ), array ('uname', 'getName', 1, 'callback' ) );
		public $viewFields = array (
				'Work' => array ('id', 'code', 'date', 'remark', 'status', 'uid', 'uname', 'ucode', 'shour', 'sminute', 'ehour', 'eminute',  'description', 'awoke' )
				,'User'=>array('ucode'=>'ucode','_on'=>'Work.uid=User.id'),
				'Depart'=>array('id'=>'depart','_on'=>'User.depart=Depart.id'),
				'Type'=>array('name'=>'type','_on'=>'Work.type=Type.id')
		);
	}
?>