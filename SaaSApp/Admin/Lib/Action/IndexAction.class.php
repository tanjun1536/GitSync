<?php
// 本文档自动生成，仅供测试运行
class IndexAction extends Action {
	/**
	 * +----------------------------------------------------------
	 * 默认操作
	 * +----------------------------------------------------------
	 */
	public function index() {
		$this->display ( 'index' );
	}
	public function login() {
		$username = $_POST ['username'];
		$password = $_POST ['pwd'];
		if (! empty ( $username )) {
			$user = D("Admin.Company");
			//$data = $user->where("account = '$username'")->find();
			$data = $user->getByAccount ( $username );
			if (! empty ( $data ) && $data ['password'] == $password) {
				$_SESSION [C ( "USER_SESSION_KEY" )] = $data;
				$this->redirect( 'Company/index' );
			} else
				$this->index ();
		} else
			$this->index ();
	}
	public function logout() {
		unset ( $_SESSION[C("USER_SESSION_KEY")] );
		$this->display ( 'index' );
	}
	/**
	 * +----------------------------------------------------------
	 * 探针模式
	 * +----------------------------------------------------------
	 */
	public function checkEnv() {
		load ( 'pointer', THINK_PATH . '/Tpl/Autoindex' ); // 载入探针函数
		$env_table = check_env (); // 根据当前函数获取当前环境
		echo $env_table;
	}

}
?>