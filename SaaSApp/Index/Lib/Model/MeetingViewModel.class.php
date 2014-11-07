<?php
class MeetingViewModel extends BaseViewModel {
	protected $_auto = array (array ('code', 'getCode', 1, 'callback' ) );
	public $viewFields = array ('Meeting' => array ('id', 'day', 'hours', 'minutes', 'address', 'hosterdepart', 'hoster', 'recorderdepart', 'recorder', 'starterdepart', 'starter', 'partersid', 'partersname', 'factpartersid', 'factpartersname', 'topic', 'remark', 'atts', 'state', 'code' ), 
			'User' => array ('name'=>'hname','ucode' => 'hucode', '_on' => 'Meeting.hoster=HUser.id','_as'=>'HUser' ), 
			'User' => array ('name'=>'rname','ucode' => 'rucode', '_on' => 'Meeting.recorder=User.id' ), 
			'User' => array ('name'=>'sname','ucode' => 'sucode', '_on' => 'Meeting.starter=User.id') );
}
?>