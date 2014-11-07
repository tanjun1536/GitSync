<?php
class BaseModel extends Model {
	function getDate() {
		return date ( "Y-m-d H:i:s" );
	}
	function getCode() {
		return $_SESSION [C ( "USER_SESSION_KEY" )] ["code"];
	}
	function getUCode() {
		return $_SESSION [C ( "USER_SESSION_KEY" )] ["ucode"];
	}
	function getId() {
		return $_SESSION [C ( "USER_SESSION_KEY" )] ["id"];
	}
	function getName() {
		return $_SESSION [C ( "USER_SESSION_KEY" )] ["name"];
	}
	function getWhere() {
		return " code='" . $this->getCode() . "' ";
	}
	function selectByCode()
	{
		return  $this->where($this->getWhere())->select();
	}
}
?>