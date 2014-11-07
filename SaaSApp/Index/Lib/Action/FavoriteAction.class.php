<?php
class FavoriteAction extends BaseAction {
	function AddFavorite() {
		$favorite = new FavoriteModel ();
		//查询所有的菜单
		
		$topMenus = $favorite->relation ( true )->where ( " `level`= 1 and iscase=0 " )->select ();
		foreach ( $topMenus as &$menu ) {
			if (! empty ( $menu ['children'] )) {
				foreach ( $menu ['children'] as &$cmenu ) {
					$data = $favorite->query ( "SELECT * FROM favorite WHERE parent_id = " . $cmenu ['id'] );
					// var_dump($data);
					$cmenu ['children'] = $data;
				}
			}
		}
		$this->assign ( "topMenus", $topMenus );
// 		$downMenus = $favorite->relation ( true )->where ( " `level`= 1 and iscase=1 " )->select ();
		
// 		foreach ( $downMenus as &$menu ) {
// 			if (! empty ( $menu ['children'] )) {
// 				foreach ( $menu ['children'] as &$cmenu ) {
// 					$data = $favorite->query ( "SELECT * FROM favorite WHERE parent_id = " . $cmenu ['id'] );
// 					// var_dump($data);
// 					$cmenu ['children'] = $data;
// 				}
// 			}
// 		}
// 		$this->assign ( "downMenus", $downMenus );
		//查询原来有的菜单
		$hasMenus=$favorite->query("SELECT favorite from user_favorite where userid=".$this->id);
		foreach ($hasMenus as $k=>$v)
		{
			$data[$k]=$v['favorite'];
		}
		//var_dump($data);
		$data=implode(",", $data);
		//var_dump($data);
		$this->assign('hasMenus',$data);
		
		$this->display ( 'AddFavorite' );
	}
	function index() {
		
		$favorite = new FavoriteModel ();
		$topMenus = $favorite->relation ( true )->where ( " `level`= 1 and iscase=0 and id in (select favorite from user_favorite where userid=$this->id)" )->select ();
		foreach ( $topMenus as &$menu ) {
			if (! empty ( $menu ['children'] )) {
				foreach ( $menu ['children'] as &$cmenu ) {
					$data = $favorite->query ( "SELECT * FROM favorite WHERE parent_id = " . $cmenu ['id'] );
					// var_dump($data);
					$cmenu ['children'] = $data;
				}
			}
		}
		$this->assign ( "topMenus", $topMenus );
// 		$downMenus = $favorite->relation ( true )->where ( " `level`= 1 and iscase=1 and id in (select favorite from user_favorite where userid=$this->id) " )->select ();
		
// 		foreach ( $downMenus as &$menu ) {
// 			if (! empty ( $menu ['children'] )) {
// 				foreach ( $menu ['children'] as &$cmenu ) {
// 					$data = $favorite->query ( "SELECT * FROM favorite WHERE parent_id = " . $cmenu ['id'] );
// 					// var_dump($data);
// 					$cmenu ['children'] = $data;
// 				}
// 			}
// 		}
// 		$this->assign ( "downMenus", $downMenus );
		$this->display ( 'Favorite' );
	}
	function SaveFavorite() {
		$dao = M ( 'user_favorite' );
		$mm = $_POST ['m'];
		$userid = $this->id;
		$dao->startTrans ();
		try {
			$ret = $dao->execute ( "DELETE FROM user_favorite WHERE userid=" . $userid );
			$this->checkExcept ( $ret );
			foreach ( $mm as $favorite ) {
				$data ['userid'] = $userid;
				$data ['favorite'] = $favorite;
				$ret = $dao->add ( $data );
				$this->checkExcept ( $ret );
			}
			$dao->commit ();
		} catch ( Exception $e ) {
			$dao->rollback ();
		}
		$this->redirect('index');
	}
}
?>