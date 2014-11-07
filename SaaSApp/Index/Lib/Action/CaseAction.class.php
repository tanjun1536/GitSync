<?php

class CaseAction extends BaseAction
{

    function index()
    {
        $key = $_POST["key"];
        $model = new CaseModel();
        import("ORG.Util.Page");
        $where = $this->getWhere();
        if (! empty($key)) {
            $where = $where . " and name like '%" . $key . "%'";
        }
        $where = $where . " and id in (SELECT 
						  `case` 
						FROM
						  case_member 
						WHERE memberid = $this->id 
						UNION ALL
						SELECT 
						  `case` 
						FROM
						  case_looker 
						WHERE lookerid = $this->id  ) ";
        $count = $model->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $model->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        parent::index();
    }

    function add()
    {
        $depart = new DepartModel();
        $departs = $depart->selectByCode();
        $this->assign("departs", $departs);
        parent::add();
    }

    function view()
    {
        $id = $_GET['case'];
        // 把case的id放入session
        if (! empty($id))
            $_SESSION['case'] = $id;
        $sql = "SELECT 
			  c.*,
			  za.`name` AS zaname,
			  za.`ucode` AS zacode,
			  yw.`name` AS ywname,
			  yw.`ucode` AS ywcode,
			  dd.`name` AS ddname,
			  dd.`ucode` AS ddcode 
			FROM
			  `case` c 
			  LEFT JOIN `user` za 
			    ON c.`casefzr` = za.`id` 
			  LEFT JOIN `user` yw 
			    ON c.`businessfzr` = yw.`id` 
			  LEFT JOIN `user` dd 
			    ON c.`casedd` = dd.`id` ";
        $sql .= " where c.id= " . $_SESSION['case'];
        $case = new CaseModel();
        $data = $case->query($sql);
        $this->assign("c", $data[0]);
        $this->setSession("caseName", $data[0]["name"]);
        $this->display('view');
    }

    function edit()
    {
        // 查询部门
        parent::getDeparts();
        // 查询专案
        $id = $_GET['id'];
        $case = new CaseModel();
        $data = $case->find($id);
        $this->assign("c", $data);
        parent::edit();
    }

    function insert()
    {
        $case = new CaseModel();
        try {
            $case->startTrans();
            $case->create();
            $data = $case->create();
            $id = $data['id'];
            if (empty($id))
                $id = $case->add($data);
            else
                $case->save($data);
            $member = M('case_member');
            $member->where("`case`=" . $id . " and src='N'")->delete();
            if (! empty($data['casebelongusersid'])) {
                $membersid = explode(',', $data['casebelongusersid']);
                $membersname = explode(',', $data['casebelongusersname']);
                for ($i = 0; $i < count($membersid); $i ++) {
                    $datas['case'] = $id;
                    $datas['memberid'] = $membersid[$i];
                    $datas['src'] = 'N';
                    $member->add($datas);
                }
            }
            $looker = M('case_looker');
            $looker->where("`case`=" . $id . " and src='N'")->delete();
            if (! empty($data['casebelongusersid'])) {
                $lookersid = explode(',', $data['caselookusersid']);
                $lookersname = explode(',', $data['caselookusersname']);
                for ($i = 0; $i < count($lookersid); $i ++) {
                    $datas['case'] = $id;
                    $datas['lookerid'] = $lookersid[$i];
                    $datas['src'] = 'N';
                    $looker->add($datas);
                }
            }
            
            $case->commit();
        } catch (Exception $e) {
            $case->rollback();
        }
        $this->index();
    }

    function delete()
    {
        parent::deleteByModelName("Case");
    }
    // 組別設定
    function team()
    {
        $case = $_SESSION['case'];
        // 設置部門
        parent::getDeparts();
        // 查詢組別
        $team = M('case_team');
        $sql = "SELECT t.*,u.`name` AS uname,u.`ucode`  FROM case_team t LEFT JOIN `user` u ON t.`teamerid`=u.`id` ";
        $sql .= " WHERE t.case = " . $case;
        $list = $team->query($sql);
        $this->assign("list", $list);
        $this->display('team');
    }

    function addTeam()
    {
        $case = M('case_team');
        $data = $case->create();
        if (empty($data['id']))
            $case->add($data);
        else
            $case->save($data);
        $this->team();
    }

    function editTeam()
    {
        $case = M('case_team');
        $data = $case->find($_GET['id']);
        $this->assign("team", $data);
        $this->team();
    }

    function deleteTeam()
    {
        $team = M('case_team');
        $team->delete($_GET['id']);
        $this->team();
    }
    /*
     * 班別******************************************************************************************************************
     */
    function work()
    {
        $work = M('case_work');
        import("ORG.Util.Page");
        $where = '`case` = ' . $_SESSION['case'];
        $count = $work->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $work->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display('work');
    }

    function addWork()
    {
        $work = M('case_work');
        $data = $work->create();
        if (empty($data['id']))
            $work->add($data);
        else
            $work->save($data);
        $this->work();
    }

    function editWork()
    {
        $work = M('case_work');
        $data = $work->find($_GET['id']);
        $this->assign("work", $data);
        $this->work();
    }

    function deleteWork()
    {
        $work = M('case_work');
        $work->delete($_GET['id']);
        $this->work();
    }
    /*
     * 所属成员******************************************************************************************************************
     */
    function member()
    {
        // 查询部门
        parent::getDeparts();
        // 查询组别
        $team = M('case_team');
        $list = $team->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("teams", $list);
        // 查询所属成员
        $sql = "SELECT distinct member.*,u.name,u.ucode FROM case_member member INNER JOIN `user` u ON member.`memberid`=u.`id` WHERE member.`case`=" . $_SESSION['case'];
        import("ORG.Util.Page");
        $member = M('case_member');
        $list = $member->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $member->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('member');
    }

    function getSalary()
    {
        $id = $this->getParam('id');
        $user = M('user');
        $data = $user->find($id);
        echo $data['salary'] / 240;
    }

    function addMember()
    {
        $member = M('case_member');
        $data = $member->create();
        if (empty($data['id'])) {
            $sql = "select * from case_member where memberid=" . $data['memberid'] . " and `case`=" . $data['case'];
            $list = $member->query($sql);
            $count = count($list);
            if ($count == 0)
                $member->add($data);
        } 

        else
            $member->save($data);
        $this->member();
    }

    function editMember()
    {
        $member = M('case_member');
        $data = $member->find($_GET['id']);
        $this->assign("member", $data);
        $this->member();
    }

    function deleteMember()
    {
        $ids = $_POST["itemcheckbox"];
        $where = implode(",", $ids);
        $model = M('case_member');
        $model->delete($where);
        $this->member();
    }
    
    /*
     * 查看人员******************************************************************************************************************
     */
    function looker()
    {
        // 查询部门
        parent::getDeparts();
        
        $looker = M('case_looker');
        import("ORG.Util.Page");
        // 查询查看人员
        $sql = "SELECT looker.*,u.name,u.ucode FROM case_looker looker INNER JOIN `user` u ON looker.`lookerid`=u.`id` WHERE looker.`case`=" . $_SESSION['case'];
        import("ORG.Util.Page");
        $list = $looker->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $looker->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('looker');
    }

    function addLooker()
    {
        $looker = M('case_looker');
        $looker->create();
        $looker->add();
        $this->looker();
    }

    function deleteLooker()
    {
        $ids = $_POST["itemcheckbox"];
        $where = implode(",", $ids);
        $model = M('case_looker');
        $model->delete($where);
        $this->looker();
    }
    /*
     * 文件类别******************************************************************************************************************
     */
    function fileType()
    {
        $work = M('case_file_type');
        import("ORG.Util.Page");
        $where = '`case` = ' . $_SESSION['case'];
        $count = $work->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $work->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display('fileType');
    }

    function addFileType()
    {
        $type = M('case_file_type');
        $data = $type->create();
        if (empty($data['id']))
            $type->add($data);
        else
            $type->save($data);
        $this->fileType();
    }

    function editFileType()
    {
        $ft = M('case_file_type');
        $data = $ft->find($_GET['id']);
        $this->assign('ft', $data);
        $this->fileType();
    }

    function deleteFileType()
    {
        $ids = $_POST["itemcheckbox"];
        $where = implode(",", $ids);
        $model = M('case_file_type');
        $model->delete($where);
        $this->fileType();
    }

    function file()
    {
        // 查询类别
        $case = $_SESSION['case'];
        $ft = M('case_file_type');
        $types = $ft->where('`case`=' . $case)->select();
        $this->assign("types", $types);
        // 查询
        $ftype = $_POST['ftype'];
        $title = $_POST['name'];
        $file = M('case_file');
        $sql = "SELECT f.*,t.name,u.`name` AS uname ,u.ucode FROM case_file f INNER JOIN case_file_type t ON f.`type`=t.`id` INNER JOIN `user` u ON u.`id`=f.`createuser` WHERE f.`case`=" . $case;
        if (! empty($title)) {
            $sql = $sql . " and f.title like '%" . $title . "%'";
        }
        if (! empty($ftype)) {
            $sql = $sql . " and f.type = " . $ftype;
        }
        import("ORG.Util.Page");
        $list = $file->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $file->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        
        $this->display('file');
    }

    function addFile()
    {
        $file = M('case_file');
        $data = $file->create();
        import("ORG.Net.UploadFile");
        $up = new UploadFile();
        $up->savePath = ATTCHEMENT_PATH_CASEFILE;
        $up->saveRule = 'uniqid';
        $up->uploadReplace = true;
        if ($up->upload()) {
            $paths = "";
            $files = $up->getUploadFileInfo();
            for ($i = 0; $i <= count($files); $i ++) {
                $paths = $paths . $files[$i]["savename"];
                if ($i < count($files) - 1)
                    $paths = $paths . ",";
            }
            $data['atts'] = $paths;
        }
        if (empty($data['id']))
            $file->add($data);
        else
            $file->save($data);
        $this->file();
    }

    function editFile()
    {
        $file = M('case_file');
        $data = $file->find($_GET['id']);
        $this->assign('file', $data);
        $this->file();
    }

    function deleteFile()
    {
        $ids = $_POST["itemcheckbox"];
        $where = implode(",", $ids);
        $model = M('case_file');
        $model->delete($where);
        $this->file();
    }
    
    /*
     * 设备管理******************************************************************************************************************
     */
    // 1、类别设定
    function deviceType()
    {
        $case = $_SESSION['case'];
        $model = M('case_device_type');
        $key = $_POST["key"];
        import("ORG.Util.Page");
        $where = "`case` = " . $case;
        $count = $model->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $model->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display('deviceType');
    }

    function addDeviceType()
    {
        $dt = M('case_device_type');
        $data = $dt->create();
        if (empty($data['id']))
            $dt->add($data);
        else
            $dt->save($data);
        $this->deviceType();
    }

    function editDeviceType()
    {
        $dt = M('case_device_type');
        $data = $dt->find($_GET['id']);
        $this->assign('dt', $data);
        $this->deviceType();
    }

    function deleteDeviceType()
    {
        $dt = M('case_device_type');
        $dt->delete($_GET['id']);
        $this->deviceType();
    }

    function DeviceChildType()
    {
        // 查詢主類別
        $t = M('case_device_type');
        $types = $t->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("types", $types);
        // 查詢子類別
        import("ORG.Util.Page");
        $case = $_SESSION['case'];
        $sql = "SELECT ct.*,t.name as typename FROM case_device_child_type ct  INNER JOIN case_device_type t ON t.`id`=ct.`type` WHERE t.`case` = " . $case;
        $type = $_GET['mtype'];
        if (empty($type))
            $type = $_POST['mtype'];
        $key = $_POST['key'];
        if (! empty($key)) {
            $sql .= " AND t.`name` LIKE '%" . $key . "%'";
        }
        if (! empty($type)) {
            $this->assign("mtype", $type);
            $sql .= " AND t.`id` =" . $type;
        }
        
        $ct = M('case_device_child_type');
        $list = $ct->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " order by ordernumber limit " . $p->firstRow . ',' . $p->listRows;
            $list = $ct->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('deviceChildType');
    }

    function addDeviceChildType()
    {
        $dt = M('case_device_child_type');
        $data = $dt->create();
        if (empty($data['id']))
            $dt->add($data);
        else
            $dt->save($data);
        $this->DeviceChildType();
    }

    function editDeviceChildType()
    {
        $dt = M('case_device_child_type');
        $data = $dt->find($_GET['id']);
        $this->assign('ct', $data);
        $this->DeviceChildType();
    }

    function deleteDeviceChildType()
    {
        $dt = M('case_device_child_type');
        $dt->delete($_GET['id']);
        $this->DeviceChildType();
    }
    /*
     * 東別******************************************************************************************************************
     */
    function building()
    {
        $case = $_SESSION['case'];
        $model = M('case_device_buildingtype');
        import("ORG.Util.Page");
        $where = "`case` = " . $case;
        $count = $model->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $model->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display('building');
    }

    function addBuilding()
    {
        $dt = M('case_device_buildingtype');
        $data = $dt->create();
        if (empty($data['id']))
            $dt->add($data);
        else
            $dt->save($data);
        $this->building();
    }

    function editBuilding()
    {
        $dt = M('case_device_buildingtype');
        $data = $dt->find($_GET['id']);
        $this->assign('build', $data);
        $this->building();
    }

    function deleteBuilding()
    {
        $dt = M('case_device_buildingtype');
        $dt->delete($_GET['id']);
        $this->building();
    }
    /*
     * 樓層******************************************************************************************************************
     */
    function buildingFloor()
    {
        // 查詢東別
        $b = M('case_device_buildingtype');
        $builds = $b->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("builds", $builds);
        // 查詢
        import("ORG.Util.Page");
        $case = $_SESSION['case'];
        $sql = "SELECT f.*,b.`name` AS bname FROM `case_device_building_floor` f INNER JOIN `case_device_buildingtype` b ON f.`buildingtype`=b.`id` WHERE b.`case`= " . $case;
        $key = $_POST['build'];
        if (! empty($key)) {
            $sql .= " AND b.`id` =" . $key;
        }
        $f = M('case_device_building_floor');
        $list = $f->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $f->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('buildingFloor');
    }

    function addBuildingFloor()
    {
        $f = M('case_device_building_floor');
        $data = $f->create();
        if (empty($data['id']))
            $f->add($data);
        else
            $f->save($data);
        $this->buildingFloor();
    }

    function editBuildingFloor()
    {
        $f = M('case_device_building_floor');
        $data = $f->find($_GET['id']);
        $this->assign('floor', $data);
        $this->buildingFloor();
    }

    function deleteBuildingFloor()
    {
        $f = M('case_device_building_floor');
        $f->delete($_GET['id']);
        $this->buildingFloor();
    }
    /*
     * 區域******************************************************************************************************************
     */
    function buildingFloorArea()
    {
        // 查詢東別
        $b = M('case_device_buildingtype');
        $builds = $b->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("builds", $builds);
        //
        import("ORG.Util.Page");
        $case = $_SESSION['case'];
        $sql = "SELECT a.*,b.`name` AS bname,f.`name` AS fname FROM `case_device_building_floor_area` a INNER JOIN `case_device_building_floor` f ON a.`floor`=f.`id` INNER JOIN `case_device_buildingtype` b ON f.`buildingtype`=b.`id` WHERE b.`case`=" . $case;
        $b = parent::getParam('b');
        $f = parent::getParam('f');
        if (! empty($b)) {
            $this->assign("build", $b);
            $sql .= " AND b.`id` =" . $b;
        }
        if (! empty($f)) {
            $this->assign("floor", $f);
            $sql .= " AND f.`id` =" . $f;
        }
        $a = M('case_device_building_floor_area');
        $list = $a->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $p->parameter .= "&" . parent::getParameter();
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $a->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('buildingFloorArea');
    }

    function addBuildingFloorArea()
    {
        $a = M('case_device_building_floor_area');
        $data = $a->create();
        if (empty($data['id']))
            $a->add($data);
        else
            $a->save($data);
        $this->buildingFloorArea();
    }

    function editBuildingFloorArea()
    {
        $sql = "SELECT a.*,b.id  AS build FROM `case_device_building_floor_area` a INNER JOIN `case_device_building_floor` f ON a.`floor`=f.`id` INNER JOIN `case_device_buildingtype` b ON f.`buildingtype`=b.`id` WHERE a.`id`=" . $_GET['id'];
        $a = new Model();
        $data = $a->query($sql);
        $this->assign('area', $data[0]);
        $this->buildingFloorArea();
    }

    function deleteBuildingFloorArea()
    {
        $f = M('case_device_building_floor_area');
        $f->delete($_GET['id']);
        $this->buildingFloorArea();
    }

    function getFloor()
    {
        $bid = $_POST['bid'];
        $f = M('case_device_building_floor');
        $w = " buildingtype=" . $bid;
        $fs = $f->where($w)->select();
        echo json_encode($fs);
    }

    function getArea()
    {
        $fid = $_POST['fid'];
        $a = M('case_device_building_floor_area');
        $w = " floor=" . $fid;
        $as = $a->where($w)->select();
        echo json_encode($as);
    }
    /*
     * 保養過期******************************************************************************************************************
     */
    function maintenanceOverTime()
    {
        $mt = $_POST['mt'];
        $ct = $_POST['ct'];
        $ot = M('case_device_maintenance_overtime');
        $sql = "SELECT ov.*,mt.`name` AS mname ,ct.`name` AS cname  FROM case_device_maintenance_overtime ov INNER JOIN case_device_type mt ON mt.`id`=ov.`devicetype` INNER JOIN case_device_child_type ct ON ct.`id`=ov.`devicechildtype` ";
        $case = $_SESSION['case'];
        import("ORG.Util.Page");
        $where = " WHERE ov.`case` = " . $case;
        if (! empty($mt)) {
            $where .= " AND ov.`devicetype` =$mt ";
            $this->assign("mt", $mt);
        }
        if (! empty($ct)) {
            $where .= " AND ov.`devicechildtype` =$ct ";
            $this->assign("ct", $ct);
        }
        $list = $ot->query($sql . $where);
        $count = count($list);
        $p = $this->getPage($count);
        $page = $p->show();
        if ($count > 0) {
            $sql .= $where . " order by ov.id desc";
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $ot->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        // 查詢主類別
        $t = M('case_device_type');
        $types = $t->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("types", $types);
        $this->display('maintenanceOverTime');
    }

    function goMaintenanceOverTime()
    {
        // 查詢主類別
        $t = M('case_device_type');
        $types = $t->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("types", $types);
        // 查询班别
        $w = M('case_work');
        $works = $w->where('`case`=' . $_SESSION['case'])->select();
        $this->assign("works", $works);
        $this->display('addMaintenanceOverTime');
    }

    function addMaintenanceOverTime()
    {
        $ot = M('case_device_maintenance_overtime');
        $data = $ot->create();
        if (empty($data['id']))
            $ot->add($data);
        else
            $ot->save($data);
        $this->maintenanceOverTime();
    }

    function maintenanceOverTimeView()
    {
        $ot = M('case_device_maintenance_overtime');
        $sql = "SELECT ov.*,mt.`name` AS mname ,ct.`name` AS cname  FROM case_device_maintenance_overtime ov INNER JOIN case_device_type mt ON mt.`id`=ov.`devicetype` INNER JOIN case_device_child_type ct ON ct.`id`=ov.`devicechildtype` where ov.id=" . $_GET['id'];
        
        $data = $ot->query($sql);
        $this->assign("ov", $data[0]);
        $this->display('maintenanceOverTimeView');
    }

    function editMaintenanceOverTime()
    {
        $ot = M('case_device_maintenance_overtime');
        $sql = "SELECT ov.*,mt.`name` AS mname ,ct.`name` AS cname  FROM case_device_maintenance_overtime ov INNER JOIN case_device_type mt ON mt.`id`=ov.`devicetype` INNER JOIN case_device_child_type ct ON ct.`id`=ov.`devicechildtype` where ov.id=" . $_GET['id'];
        
        $data = $ot->query($sql);
        $this->assign("ov", $data[0]);
        $this->goMaintenanceOverTime();
    }

    function deleteMaintenaceOverTime()
    {
        $ot = M('case_device_maintenance_overtime');
        $ot->delete($_GET['id']);
        $this->maintenanceOverTime();
    }

    function dayMaintenanceRecord()
    {
        $case = $_SESSION['case'];
        $state = parent::getParam('state');
        $sdate = parent::getParam('sdate');
        $edate = parent::getParam('edate');
        $mt = parent::getParam('stype');
        $csql = "SELECT 
				COUNT(*)
				  FROM
				    `case_device_maintenance_scheduling` s 
				    INNER JOIN `case_device_maintenance_scheduling_daily` sd 
				      ON s.`id` = sd.`sechdul` 
				    INNER JOIN case_device_type t 
				      ON t.`id` = sd.`devicetype` 
				    INNER JOIN case_device_child_type ct 
				      ON ct.`id` = sd.`devicechildtype`
				    INNER JOIN `case_device_maintenance_overtime` ov 
				    ON ov.`id`=sd.`overtime`
				    INNER JOIN `case_work` w ON w.`id`=ov.`work`
				      WHERE s.`case`= $case ";
        $dsql = "SELECT * FROM (SELECT 
				  *,
				  (
				    CASE
				      WHEN alreadymaintenance = 0 
				      THEN '未保養' 
				       WHEN alreadymaintenance = needmaintenance 
				      THEN '已保養' 
				      ELSE
					'保養中'
				    END
				  ) AS state 
				FROM
				  (SELECT 
				    sd.*,
				    t.`name` AS tname,
				    ct.`name` AS cname,
				    s.`code`,s.`case`,
				    w.workcode,
				    ov.name otname,
				    (SELECT 
				      COUNT(d.id) 
				    FROM
				      case_device d 
				    WHERE d.`case` = s.`case` 
				      AND d.`childtype` = sd.devicechildtype) AS needmaintenance,
				    (SELECT 
				      COUNT(id) 
				    FROM
				      `case_device_maintenance_scheduling_daily_maintenaced` al 
				    WHERE al.`sechudl` = s.`id` 
				      AND al.`overtime` = sd.`overtime` 
				      AND al.`times` = sd.`times`) AS alreadymaintenance 
				  FROM
				    `case_device_maintenance_scheduling` s 
				    INNER JOIN `case_device_maintenance_scheduling_daily` sd 
				      ON s.`id` = sd.`sechdul` 
				    INNER JOIN case_device_type t 
				      ON t.`id` = sd.`devicetype` 
				    INNER JOIN case_device_child_type ct 
				      ON ct.`id` = sd.`devicechildtype`
				    INNER JOIN `case_device_maintenance_overtime` ov 
				    ON ov.`id`=sd.`overtime`
				    INNER JOIN `case_work` w ON w.`id`=ov.`work`
				      WHERE s.`case`=$case ";
        
        if (! empty($sdate)) {
            $csql .= " AND sechduldate>='$sdate' ";
            $dsql .= " AND sechduldate>='$sdate' ";
            $this->assign("sdate", $sdate);
        }
        if (! empty($edate)) {
            $csql .= " AND sechduldate<='$edate' ";
            $dsql .= " AND sechduldate<='$edate' ";
            $this->assign("etate", $edate);
        }
        if (empty($edate) && empty($sdate)) {
            $csql .= " AND PERIOD_DIFF(DATE_FORMAT(NOW(), '%Y%m'), DATE_FORMAT(sechduldate, '%Y%m'))=0 ";
            $dsql .= " AND PERIOD_DIFF(DATE_FORMAT(NOW(), '%Y%m'), DATE_FORMAT(sechduldate, '%Y%m'))=0 ";
        }
        if (! empty($mt)) {
            $csql .= " AND sd.devicetype=$mt ";
            $dsql .= " AND sd.devicetype=$mt ";
            $this->assign("mt", $mt);
        }
        $dsql .= " )z)y";
        if (! empty($state)) {
            $dsql .= " WHERE state='$state' ";
            $this->assign("state", $state);
        }
        $this->page($csql, $dsql);
        
        // 查詢主類別
        $t = M('case_device_type');
        $types = $t->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("types", $types);
        $this->display('dayMaintenanceRecord');
    }

    function getDeviceChildType()
    {
        $id = $_POST['id'];
        $ct = M('case_device_child_type');
        $w = " type=" . $id;
        $cts = $ct->where($w)->select();
        echo json_encode($cts);
    }

    function deleteMaintenanceOverTime()
    {
        $ot = M('case_device_maintenance_overtime');
        $id = $_GET['id'];
        $ot->delete($id);
        $this->maintenanceOverTime();
    }

    function dayMaintenanceRecordDevice()
    {
        $case = $_SESSION['case'];
        $ctid = $_GET['ctid'];
        $overtime = $_GET['overtimeid'];
        $sechudl = $_GET['sechudlid'];
        $times = $_GET['t'];
        $date = $_GET['d'];
        $sql = "SELECT 
 			 sd.* ,s.`code`,ct.`name` AS cname,d.`name` AS dname,d.`devicecode` AS devicecode,d.id AS deviceid,IF(ISNULL(already.`id`),'未保養','已保養') AS state
			FROM
  `case_device_maintenance_scheduling_daily` sd 
  INNER JOIN case_device d 
    ON sd.devicechildtype = d.`childtype` 
    INNER JOIN `case_device_maintenance_scheduling` s ON sd.`sechdul`=s.`id`
    INNER JOIN case_device_child_type ct ON ct.`id`=d.`childtype` 
    LEFT OUTER JOIN  `case_device_maintenance_scheduling_daily_maintenaced` already
    ON d.`case`=already.`case` AND  sd.`sechdul`=already.`sechudl` AND sd.`overtime`=already.`overtime` AND sd.`times`=already.`times` AND d.`id`=already.`deviceid`
			    
			   WHERE sd.sechduldate='$date' and sd.`sechdul`=$sechudl AND sd.`overtime`=$overtime AND sd.`times`=$times AND d.`case`=$case AND sd.`devicechildtype` =$ctid";
        $d = new Model();
        $data = $d->query($sql);
        $this->assign("list", $data);
        $this->display("dayMaintenanceRecordDevice");
    }
    /*
     * 設備******************************************************************************************************************
     */
    function deviceIndex()
    {
        import("ORG.Util.Page");
        // 查詢東別
        // 查詢東別
        $b = M('case_device_buildingtype');
        $builds = $b->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("builds", $builds);
        // $sql="SELECT a.* FROM `case_device_building_floor_area` a INNER JOIN
        // `case_device_building_floor` f ON a.`floor`=f.`id` INNER JOIN
        // `case_device_buildingtype` b ON f.`buildingtype`=b.`id` WHERE
        // b.`case`=".$_GET['case'];
        // $b = new Model();
        // $areas = $b->query($sql);
        // $this->assign ( "areas", $areas );
        // 查詢主類別
        $t = M('case_device_type');
        $types = $t->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("types", $types);
        // 查詢設備
        $sql = "SELECT d.*,a.`name` AS aname,f.name  AS fname ,t.`name` AS tname ,ct.`name` AS ctname FROM case_device d INNER JOIN case_device_building_floor_area a ON d.`area`=a.id INNER JOIN case_device_building_floor f ON d.floor=f.id INNER JOIN case_device_type t ON d.`type`=t.`id` INNER JOIN case_device_child_type ct ON d.`childtype`=ct.`id` WHERE d.`case`=" . $_SESSION['case'];
        $name = parent::getParam('dname');
        $code = parent::getParam('dcode');
        $build = parent::getParam('dbuild');
        $floor = parent::getParam('dfloor');
        $area = parent::getParam('darea');
        $type = parent::getParam('dtype');
        if (! empty($name)) {
            $sql .= " AND d.name like '%" . $name . "%'";
            $this->assign("dname", $name);
        }
        if (! empty($code)) {
            $sql .= " AND d.devicecode like '%" . $code . "%'";
            $this->assign("dcode", $code);
        }
        if (! empty($build)) {
            $sql .= " AND d.build=" . $build;
            $this->assign("dbuild", $build);
        }
        if (! empty($floor)) {
            $sql .= " AND d.floor=" . $floor;
            $this->assign("dfloor", $floor);
        }
        if (! empty($area)) {
            $sql .= " AND d.area=" . $area;
            $this->assign("darea", $area);
        }
        if (! empty($type)) {
            $sql .= " AND d.type=" . $type;
            $this->assign("dtype", $type);
        }
        $d = M('case_device');
        $list = $d->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $p->parameter = "&" . parent::getParameter();
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $d->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('deviceIndex');
    }

    function addDevice()
    {
        // 查詢東別
        $b = M('case_device_buildingtype');
        $builds = $b->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("builds", $builds);
        // 查詢主類別
        $t = M('case_device_type');
        $types = $t->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("types", $types);
        
        $this->display('addDevice');
    }

    function insertDevice()
    {
        $device = M('case_device');
        $data = $device->create();
        if (empty($data['id']))
            $device->add($data);
        else
            $device->save($data);
        $this->deviceIndex();
    }

    function viewDevice()
    {
        $id = $_GET['id'];
        $sql = "SELECT d.*,a.`name` AS aname,t.`name` AS tname ,ct.`name` AS ctname FROM case_device d INNER JOIN case_device_building_floor_area a ON d.`area`=a.id INNER JOIN case_device_type t ON d.`type`=t.`id` INNER JOIN case_device_child_type ct ON d.`childtype`=ct.`id` WHERE d.`id`=" . $id;
        $m = new Model();
        $data = $m->query($sql);
        $this->assign("dev", $data[0]);
        $this->display('viewDevice');
    }

    function editDevice()
    {
        // 查詢東別
        $b = M('case_device_buildingtype');
        $builds = $b->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("builds", $builds);
        // 查詢主類別
        $t = M('case_device_type');
        $types = $t->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("types", $types);
        // 查询设备
        $dt = M('case_device');
        $data = $dt->find($_GET['id']);
        $this->assign('dev', $data);
        $this->display('editDevice');
    }

    function deleteDevices()
    {
        $ids = $_POST["itemcheckbox"];
        $where = implode(",", $ids);
        $model = M('case_device');
        $model->delete($where);
        $this->redirect("deviceIndex");
    }
    // 排程*********************************************************************
    function maintenanceScheduling()
    {
        $model = M('case_device_maintenance_scheduling');
        import("ORG.Util.Page");
        $where = "`case` = " . $_SESSION['case'];
        $state = $_POST['st'];
        if (! empty($state)) {
            $where .= " and state='" . $state . "'";
        }
        $count = $model->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $model->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display('maintenanceScheduling');
    }

    function addScheduling()
    {
        $device = M('case_device_maintenance_scheduling');
        try {
            $device->startTrans();
            // 保存主表
            
            $data = $device->create();
            $id = $data['id'];
            if (empty($id))
                $id = $device->add($data);
            else
                $device->save($data);
            $case = $_SESSION['case'];
            $year = $data['year'];
            $month = $data['month'];
            if ($month == 12) {
                
                $startDate = "$year-$month-01";
                $eYear = $year + 1;
                $endDate = $eYear . '-01-01';
            } else {
                $startDate = "$year-$month-01";
                $eMonth = $month + 1;
                $endDate = "$year-$eMonth-01";
            }
            // 插入子表
            $sql = "INSERT INTO `case_device_maintenance_scheduling_daily`
				            (
				             `sechdul`,
				             `sechdulcode`,
				             `sechduldate`,
				             `devicetype`,
				             `devicechildtype`,
				             `overtime`,
				             `times`)
				SELECT $id,'', days.dt,o.devicetype,o.devicechildtype,o.id,(
				CASE o.`type` 
					WHEN 'D' THEN days.`day`
					WHEN 'W' THEN (DAY(days.dt)+WEEKDAY(days.dt-INTERVAL DAY(days.dt) DAY)) DIV 7 + 1
					WHEN 'M' THEN 1
					WHEN 'Q' THEN 1
					WHEN 'H' THEN 1
					WHEN 'Y' THEN 1
				END
				 ) AS times FROM 
				(
					SELECT CONCAT('$year','-','$month','-',`day`) AS dt,`day` FROM `case_device_maintenance_days` 
				
					WHERE `day` <= DATEDIFF(
							    '$endDate',
							    '$startDate'
							  )
				)days , case_device_maintenance_overtime o
				
							WHERE o.`case`=$case 
							  AND ((o.`type`='D') 
							     OR (
							     o.`type`='W' AND (
							     IF(DAYOFWEEK( days.dt)-1=0,7,DAYOFWEEK( days.dt)-1)=o.`startday` OR
							     IF(DAYOFWEEK( days.dt)-1=0,7,DAYOFWEEK( days.dt)-1)-o.`startday` <o.`costday`
							     ) )
				 				OR (
							     o.`type`='M' AND (
							     DAYOFMONTH(days.dt)=o.`startday` OR (
							     DAYOFMONTH(days.dt) >o.`startday` AND
							     DAYOFMONTH(days.dt)-o.`startday` <o.`costday`)
							     ) )
							     OR (
							     (o.`type`='Q') 
							     AND (MONTH(days.dt)=o.`startmonth` OR (MONTH(days.dt)>o.`startmonth` AND (MONTH(days.dt)-o.`startmonth`)%3=0)  ) 
							     AND (
							     
							     DAYOFMONTH(days.dt)=o.`startday` OR
							     (DAYOFMONTH(days.dt) >o.`startday` AND
							     DAYOFMONTH(days.dt)-o.`startday` <o.`costday`)
							     ) )
							     OR (
							     ( o.`type`='H') 
							     AND (MONTH(days.dt)=o.`startmonth` OR (MONTH(days.dt)>o.`startmonth` AND (MONTH(days.dt)-o.`startmonth`)%6=0)  ) 
							     AND (
							     
							     DAYOFMONTH(days.dt)=o.`startday` OR
							     (DAYOFMONTH(days.dt) >o.`startday` AND
							     DAYOFMONTH(days.dt)-o.`startday` <o.`costday`)
							     ) )
							     OR (
							     (o.`type`='Y') 
							     AND MONTH(days.dt)=o.`startmonth` 
							     AND (
							     
							     DAYOFMONTH(days.dt)=o.`startday` OR
							     (DAYOFMONTH(days.dt) >o.`startday` AND
							     DAYOFMONTH(days.dt)-o.`startday` <o.`costday`)
							     ) )
							     
							     )

		";
            // echo $sql;
            $device->execute($sql);
            $device->commit();
        } catch (Exception $e) {
            
            echo $e->getMessage();
            $device->rollback();
        }
        
        $this->redirect('maintenanceScheduling');
    }

    function doChangeMaintenaceScheduling()
    {
        $id = $_POST['id'];
        $date = $_POST['date'];
        $s = M('case_device_maintenance_scheduling_daily');
        $s->where('id=' . $id)->setField('sechduldate', $date);
        $this->dayMaintenanceRecord();
    }

    function deleteScheduling()
    {
        $ids = $_POST["itemcheckbox"];
        $where = implode(",", $ids);
        $model = M('case_device_maintenance_scheduling');
        $model->delete($where);
        $this->maintenanceScheduling();
    }

    function sureScheduling()
    {
        $ids = $_POST["itemcheckbox"];
        $where = implode(",", $ids);
        $model = M('case_device_maintenance_scheduling');
        $sql = " update case_device_maintenance_scheduling set state='確認' where id in(" . $where . ")";
        $model->query($sql);
        $this->maintenanceScheduling();
    }
    // 排程表********************************************************************
    function schedulingCheck()
    {
        // 根据id查询保养排程
        $id = $_GET['id'];
        $case = $_SESSION['case'];
        $model = M('case_device_maintenance_scheduling');
        $schedul = $model->find($id);
        $this->assign("schedul", $schedul);
        for ($i = 0; $i < 31; $i ++) {
            if ($i < 10)
                $dates[$i] = $schedul['year'] . "-" . $schedul['month'] . "-0" . ($i + 1);
            else
                $dates[$i] = $schedul['year'] . "-" . $schedul['month'] . "-" . ($i + 1);
            $days[$i] = $i + 1;
        }
        // 设置时间
        $this->assign("dates", $dates);
        $this->assign("days", $days);
        // 查询过期
        $sql = "SELECT o.*,t.`name` AS tname,ct.`name` AS ctname  FROM `case_device_maintenance_overtime` o INNER JOIN case_device_type t ON o.`devicetype`=t.`id` INNER JOIN case_device_child_type ct ON ct.`id`=o.`devicechildtype` WHERE o.`case` =" . $case . " AND ((o.`type`='W')OR(o.`type`='D')OR(o.`type`='M')OR(o.`startmonth`='0')OR (o.`startmonth`='" . str_replace('0', '', $schedul['month']) . "'))";
        $list = $model->query($sql);
        $this->assign("list", $list);
        $this->display('schedulingCheck');
    }
    
    // 保养记录********************************************************************
    function maintenanceRecord()
    {
        $state = $this->getParam('sstate');
        $sdate = $this->getParam('sdate');
        $edate = $this->getParam('edate');
        
        $sql = "SELECT * FROM (SELECT 
				  i.*,
			  if(ISNULL(i.state),
			  IF(
			    ISNULL(z.cstate),
			    '正常',
			    '異常'
			  ),IF(LENGTH(TRIM(i.`state`))<1,'正常','異常')) cstate 
				FROM
				  case_device_maintenance_detail_instance i 
				  LEFT  JOIN 
				    (SELECT 
				       COUNT(b.id) AS cstate,
				      b.`instance` 
				    FROM
				      `case_device_maintenance_detail_instance_detail` b 
				     
				    WHERE result = '異常' 
				      OR result < `floor` 
				      OR result > cap 
				    GROUP BY b.`instance`) z 
				    ON i.`id` = z.instance 
				WHERE i.`case`=" . $_SESSION['case'] . ") x";
        /*
         * INNER JOIN `case_device_maintenance_detail` c ON c.`id` = b.`detail`
         */
        $where = null;
        if (! empty($state)) {
            $where = " WHERE cstate ='$state'";
            $this->assign('state', $state);
        }
        
        if (! empty($sdate)) {
            if (empty($where))
                $where = " WHERE maintenancedate >='$sdate'";
            else
                $where .= " AND maintenancedate >='$sdate'";
            $this->assign('sdate', $sdate);
        }
        
        if (! empty($edate)) {
            if (empty($where))
                $where = " WHERE maintenancedate <='$edate 23:59:59' ";
            else
                $where .= " AND maintenancedate <='$edate 23:59:59' ";
            $this->assign('edate', $edate);
        }
        
        $sql .= " $where order by id desc ";
        import("ORG.Util.Page");
        $instance = new Model();
        $list = $instance->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $instance->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('maintenanceRecord');
    }

    function addMaintenanceRecord()
    {
        // 查詢主類別
        $t = M('case_device_type');
        $types = $t->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("types", $types);
        $this->assign("linecode", getCaseMaintenanceLineCode($_SESSION['case']));
        $this->display('addMaintenanceRecord');
    }

    function insertMaintenanceRecord()
    {
        // 保存主表
        $maintenance = M('case_device_maintenance_detail_instance');
        try {
            $maintenance->startTrans();
            $data = $maintenance->create();
            $id = $data['id'];
            if (empty($id)) {
                $id = $maintenance->add($data);
                $this->addDetail($id, false);
            } else {
                $maintenance->save($data);
                $this->addDetail($id, true);
            }
            // 保存已經維護的列表
            $daily = M('case_device_maintenance_scheduling_daily_maintenaced');
            $datas['case'] = $_POST['case'];
            $datas['sechudl'] = $_POST['sechudl'];
            $datas['overtime'] = $_POST['overtime'];
            $datas['times'] = $_POST['times'];
            $datas['deviceid'] = $_POST['deviceid'];
            $daily->add($datas);
            $worklog = M('work');
            $work['date'] = $data['maintenancedate'];
            $work['typename'] = '設備保養';
            $work['description'] = $data['maintenancecode'] . ',' . $_POST['type'] . ',' . $_POST['childtype'] . ',' . $_POST['devicecode'] . ',' . $_POST['devicename'];
            $work['status'] = '完成工作';
            $work['awoke'] = 0;
            $work['uid'] = $this->getId();
            $work['code'] = $this->code;
            $worklog->add($work);
            $maintenance->commit();
        } catch (Exception $e) {
            $maintenance->rollback();
        }
        $this->maintenanceRecord();
    }

    function maintenanceRecordView()
    {
        $sql = "SELECT cdmd.*,cdt.`id` AS tid ,cdct.`id` AS ctid,cdt.`name` AS tname ,cdct.`name` AS ctname FROM `case_device_maintenance_detail_instance` cdmd INNER JOIN case_device c ON c.`devicecode`=cdmd.`devicecode`
			  INNER JOIN case_device_child_type cdct ON c.`childtype`=cdct.`id` INNER JOIN case_device_type cdt ON c.`type` =cdt.`id` WHERE cdmd.`id`=" . $_GET['id'];
        $m = new Model();
        $data = $m->query($sql);
        $this->assign("ins", $data[0]);
        // 查詢明細
        $sql = "SELECT 
			  * ,
			  CASE WHEN `result`='正常' THEN '正常'
			       WHEN `result`='異常' THEN '異常'
			        WHEN `result`>=floor AND `result`<=cap THEN '正常'
			        ELSE '異常'
			  END AS cstate
			 FROM
			  `case_device_maintenance_detail_instance_detail`  
			 WHERE instance=" . $_GET['id'];
        /*
         * INNER JOIN `case_device_maintenance_detail` cdmd ON cdmdid.`detail` = cdmd.`id`
         */
        
        $datas = $m->query($sql);
        $this->assign("details", $datas);
        $this->display("maintenanceRecordView");
    }

    function editMaintenanceRecord()
    {
        // 查詢主類別
        $t = M('case_device_type');
        $types = $t->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("types", $types);
        // 查詢主表
        $sql = "SELECT cdmd.*,cdt.`id` AS type ,cdct.`id` AS childtype FROM `case_device_maintenance_detail_instance` cdmd INNER JOIN case_device c ON c.`devicecode`=cdmd.`devicecode`
		INNER JOIN case_device_child_type cdct ON c.`childtype`=cdct.`id` INNER JOIN case_device_type cdt ON c.`type` =cdt.`id` WHERE cdmd.`id`=" . $_GET['id'];
        $m = new Model();
        $data = $m->query($sql);
        $this->assign("data", $data[0]);
        // 查詢明細
        $sql = "SELECT
		cdmd.*,
		cdmdid.`instance`,
		cdmdid.`result`,
		cdmdid.`remark` 
		FROM
		`case_device_maintenance_detail_instance_detail` cdmdid
		INNER JOIN `case_device_maintenance_detail` cdmd
		ON cdmdid.`detail` = cdmd.`id`  WHERE cdmdid.instance=" . $_GET['id'];
        
        $datas = $m->query($sql);
        $this->assign("details", $datas);
        $this->display("editMaintenanceRecord");
    }

    function addDetail($id, $isUpdate)
    {
        //
        $m = M('case_device_maintenance_detail_instance_detail');
        if ($isUpdate)
            $m->where('instance =' . $id)->delete();
        $detail = $_POST['details'];
        $details = json_decode($detail, true);
        $data['instance'] = $id;
        foreach ($details as $key => $value) {
            $data['project'] = $value['project'];
            $data['type'] = $value['type'];
            $data['floor'] = $value['floor'];
            $data['cap'] = $value['cap'];
            $data['descript'] = $value['descript'];
            $data['detail'] = $value['detail'];
            $data['result'] = $value['result'];
            $data['remark'] = $value['remark'];
            $m->add($data);
        }
    }

    function deleteMaintenanceRecord()
    {
        // 删除主表
        $ids = $_POST["itemcheckbox"];
        $where = implode(",", $ids);
        $model = M('case_device_maintenance_detail_instance');
        try {
            $model->startTrans();
            $model->delete($where);
            $model = M('case_device_maintenance_detail_instance_detail');
            $model->where('instance in (' . $where . ')')->delete();
            $model->commit();
        } catch (Exception $e) {
            $model->rollback();
        }
        $this->maintenanceRecord();
    }
    // 保养明细
    function maintenanceRecordDetail()
    {
        $mt = $_POST['mt'];
        $ct = $_POST['ct'];
        $sql = "SELECT m.*,t.`name` AS tname ,ct.name AS ctname,o.`name` AS oname FROM `case_device_maintenance` m INNER JOIN `case_device_type` t ON m.`type`=t.`id` INNER JOIN `case_device_child_type` ct ON m.`childtype`=ct.`id` INNER JOIN `case_device_maintenance_overtime` o ON m.`overtime`=o.`id` ";
        
        $where = " WHERE m.`case`=" . $_SESSION['case'];
        
        $d = new Model();
        if (! empty($mt)) {
            $where .= " AND o.`devicetype` =$mt ";
            $this->assign("mt", $mt);
        }
        if (! empty($ct)) {
            $where .= " AND o.`devicechildtype` =$ct ";
            $this->assign("ct", $ct);
        }
        import("ORG.Util.Page");
        $sql .= $where;
        $list = $d->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $d->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        // 查詢主類別
        $t = M('case_device_type');
        $types = $t->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("types", $types);
        $this->display('maintenanceRecordDetail');
    }

    function goAddMaintenanceRecordDetail()
    {
        // 查詢主類別
        $t = M('case_device_type');
        $types = $t->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("types", $types);
        $this->display('addMaintenanceRecordDetail');
    }

    function addMaintenanceRecordDetail()
    {
        // 保存主表
        $maintenance = M('case_device_maintenance');
        
        $data = $maintenance->create();
        $id = $data['id'];
        try {
            $maintenance->startTrans();
            if (empty($id)) {
                $id = $maintenance->add($data);
                $this->checkExcept($id);
                $this->saveDetail($id, false);
            } else {
                $ret = $maintenance->save($data);
                $this->checkExcept($ret);
                $this->saveDetail($id, true);
            }
            $maintenance->commit();
        } catch (Exception $e) {
            $maintenance->rollback();
        }
        
        $this->maintenanceRecordDetail();
    }

    function editMaintenanceRecordDetail()
    {
        // 查詢主表
        $id = $_GET['id'];
        $maintenance = M('case_device_maintenance');
        $data = $maintenance->find($id);
        $this->assign("maintenance", $data);
        // 查詢子表
        $detail = M('case_device_maintenance_detail');
        $details = $detail->where('maintenanceovertime = ' . $id)->select();
        $this->assign("details", $details);
        $this->goAddMaintenanceRecordDetail();
    }

    function deleteMaintenanceRecordDetail()
    {
        // 查詢主表
        $id = $_GET['id'];
        $model = M('case_device_maintenance');
        try {
            $model->startTrans();
            $model->delete($id);
            $model = M('case_device_maintenance_detail');
            $model->where('maintenanceovertime =' . $id)->delete();
            $model->commit();
        } catch (Exception $e) {
            $model->rollback();
        }
        $this->maintenanceRecordDetail();
    }

    function saveDetail($id, $isUpdate)
    {
        $model = M('case_device_maintenance_detail');
        if ($isUpdate)
            $model->where('maintenanceovertime =' . $id)->delete();
        $datas = $_POST['detail'];
        $data['maintenanceovertime'] = $id;
        foreach ($datas as $key => $value) {
            $vs = explode(",", $value);
            $data['project'] = $vs[0];
            $data['type'] = $vs[1];
            $data['standard'] = $vs[2];
            $data['floor'] = $vs[3];
            $data['cap'] = $vs[4];
            $data['descript'] = $vs[5];
            $ret = $model->add($data);
            $this->checkExcept($ret);
        }
    }
    // ajax查詢過期
    function getOverTime()
    {
        $case = $_POST['case'];
        $type = $_POST['type'];
        $childtype = $_POST['childtype'];
        $where = " `case` =" . $case . " and devicetype= " . $type . " and devicechildtype =" . $childtype;
        $ov = M('case_device_maintenance_overtime');
        $datas = $ov->where($where)->select();
        echo json_encode($datas);
    }
    // ajax 查询设备
    function getDevice()
    {
        $case = $_POST['case'];
        $type = $_POST['type'];
        $childtype = $_POST['childtype'];
        $build = $_POST['build'];
        $floor = $_POST['floor'];
        $area = $_POST['area'];
        $where = " `case` =" . $case;
        if (! empty($type))
            $where .= " and type= " . $type;
        if (! empty($childtype))
            $where .= " and childtype= " . $childtype;
        if (! empty($build))
            $where .= " and build= " . $build;
        if (! empty($floor))
            $where .= " and floor= " . $floor;
        if (! empty($area))
            $where .= " and area= " . $area;
        $ov = M('case_device');
        $datas = $ov->where($where)->select();
        echo json_encode($datas);
    }
    // ajax 查询详细
    function getDetails()
    {
        $id = $_POST['id'];
        $sql = " SELECT	d.* FROM `case_device_maintenance_detail`  d 
				INNER JOIN case_device_maintenance m ON d.`maintenanceovertime`=m.`id` WHERE overtime=" . $id;
        $M = new Model();
        $datas = $M->query($sql);
        echo json_encode($datas);
    }
    // ajax 查询详细
    function getDetailsHasValue()
    {
        $id = $_POST['id'];
        $sql = " SELECT	d.* FROM `case_device_maintenance_detail`  d INNER JOIN case_device_maintenance m ON d.`maintenanceovertime`=m.`id` WHERE overtime=" . $id;
        $M = new Model();
        $datas = $M->query($sql);
        echo json_encode($datas);
    }
    
    // 维修管理
    function repair()
    {
        $state = $this->getParam('sstate');
        $devicename = $this->getParam('name');
        $repaircode = $this->getParam('code');
        
        $askman = $this->getParam('askman');
        $sdate = $this->getParam('sdate');
        $edate = $this->getParam('edate');
        $sdispatcher = $this->getParam('sdispatcher');
        $d = addDay($edate);
        
        $build = $this->getParam('build');
        $floor = $this->getParam('floor');
        $area = $this->getParam('area');
        $deivcetype = $this->getParam('type');
        $devicechildtype = $this->getParam('childtype');
        
        $sql = "SELECT * FROM case_device_repair ";
        $order = " order by repairdate desc";
        if (! empty($sdispatcher)) {
            $sql = "SELECT r.* FROM case_device_repair r inner join case_device_repair_dispatch m on r.id=m.repair ";
        }
        $repair = M('case_device_repair');
        $case = $_SESSION['case'];
        import("ORG.Util.Page");
        
        $q = $this->getParam('q');
        if ($q == 'sqjx') {
            $state = '申請叫修';
        } else 
            if ($q == 'pg') {
                $state = '派工';
            } else 
                if ($q == 'ww') {
                    $state = '委外';
                } else 
                    if ($q == 'wg') {
                        $state = '完工';
                    } 

                    else 
                        if ($q == 'qx') {
                            $state = '取消';
                        } else 
                            if ($q == 'ly') {
                                $sql = "SELECT r.*,m.senddate FROM case_device_repair r left outer join case_device_repair_message m on r.id=m.repair ";
                                $order = "order by m.senddate desc";
                                $this->assign('ly', '1');
                            }
        $sql .= "WHERE `case` = " . $case;
        if (! empty($state)) {
            $sql .= " AND state= '" . $state . "'";
        }
        if (! empty($devicename)) {
            $sql .= " AND devicename like '%" . $devicename . "%'";
            $this->assign("devicename", $devicename);
        }
        if (! empty($repaircode)) {
            $sql .= " AND repaircode like '%" . $repaircode . "%'";
            $this->assign("repaircode", $repaircode);
        }
        if (! empty($askman)) {
            $sql .= " AND requestuser like '%" . $askman . "%'";
            $this->assign("askman", $askman);
        }
        if (! empty($sdispatcher)) {
            $sql .= " AND dousersname like '%" . $sdispatcher . "%'";
            $this->assign("sdispatcher", $sdispatcher);
        }
        if (! empty($sdate)) {
            $sql .= " AND repairdate>= '" . $sdate . "'";
            $this->assign("sdate", $sdate);
        }
        if (! empty($edate)) {
            $sql .= " AND repairdate< '" . addDay($edate) . "'";
            $this->assign("edate", $edate);
        }
        
        if (! empty($build)) {
            $sql .= " AND build= '" . $build . "'";
            $this->assign("build", $build);
        }
        if (! empty($floor)) {
            $sql .= " AND floor= '" . $floor . "'";
            $this->assign("floor", $floor);
        }
        if (! empty($area)) {
            $sql .= " AND area= '" . $area . "'";
            $this->assign("area", $area);
        }
        if (! empty($deivcetype)) {
            $sql .= " AND type= '" . $deivcetype . "'";
            $this->assign("type", $deivcetype);
        }
        if (! empty($devicechildtype)) {
            $sql .= " AND childtype= '" . $devicechildtype . "'";
            $this->assign("childtype", $devicechildtype);
        }
        if (! empty($order)) {
            $sql .= " $order";
        }
        $list = $repair->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $p->parameter .= "&" . parent::getParameter();
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $repair->query($sql);
        }
        $this->assign("page", $page);
        $this->assign("list", $list);
        $warn = M('case_warn_days');
        $data = $warn->where('`case` = ' . $_SESSION['case'])->find();
        $this->assign('warn', $data);
        
        // 总表
        // 申请叫修
        $sql = "SELECT COUNT(*) as c FROM case_device_repair WHERE state= '申請叫修' AND `case` = " . $_SESSION['case'];
        $sqjx = $repair->query($sql);
        $this->assign('sqjx', $sqjx[0]['c']);
        // 派工
        $sql = "SELECT COUNT(*) as c FROM case_device_repair WHERE state= '派工' AND `case` = " . $_SESSION['case'];
        $pg = $repair->query($sql);
        $this->assign('pg', $pg[0]['c']);
        // 委外
        $sql = "SELECT COUNT(*) as c FROM case_device_repair WHERE state= '委外' AND `case` = " . $_SESSION['case'];
        $ww = $repair->query($sql);
        $this->assign('ww', $ww[0]['c']);
        // 取消
        // 完工
        // 留言
        
        // 查詢東別
        $b = M('case_device_buildingtype');
        $builds = $b->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("builds", $builds);
        // 查詢主類別
        $t = M('case_device_type');
        $types = $t->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("types", $types);
        
        $this->display('repair');
    }

    function exportRepair()
    {
        $state = $this->getParam('sstate');
        $devicename = $this->getParam('name');
        $repaircode = $this->getParam('code');
        
        $askman = $this->getParam('askman');
        $sdate = $this->getParam('sdate');
        $edate = $this->getParam('edate');
        $sdispatcher = $this->getParam('sdispatcher');
        $d = addDay($edate);
        
        $build = $this->getParam('build');
        $floor = $this->getParam('floor');
        $area = $this->getParam('area');
        $deivcetype = $this->getParam('type');
        $devicechildtype = $this->getParam('childtype');
        $sql = "SELECT 
			  r.`askuser`,
			  r.`requestuser`,
			  r.`repaircode`,
			  r.`repairdate`,
			  CONCAT(
			    build.`name`,
			    '/',
			    fl.`name`,
			    '/',
			    ar.`name`
			  ) AS region,
			  mt.`name` AS mainType,
			  ct.`name` AS childType,
			  r.`devicecode`,
			  r.`devicename`,
			  CONCAT(
			    IFNULL(r.remark, ''),
			    '\n',
			    IFNULL(
			      (SELECT 
			        doremark 
			      FROM
			        case_device_repair_dispatch 
			      WHERE `repair` = r.id 
			      LIMIT 1),
			      ''
			    ),
			    '\n',
			    IFNULL(
			      (SELECT 
			        remark 
			      FROM
			        case_device_repair_delegate 
			      WHERE `repair` = r.id 
			      LIMIT 1),
			      ''
			    ),
			    '\n',
			    IFNULL(
			      (SELECT 
			        completeremark 
			      FROM
			        case_device_repair_complete 
			      WHERE `repair` = r.id 
			      LIMIT 1),
			      ''
			    ),
			    '\n',
			    IFNULL(
			      (SELECT 
			        GROUP_CONCAT(msg) 
			      FROM
			        `case_device_repair_message` 
			      WHERE `repair` = r.id),
			      ''
			    )
			  ) AS msg,
			  (SELECT 
			    `dotimeandusers` 
			  FROM
			    `case_device_repair_complete` 
			  WHERE `repair` = r.`id` 
			  LIMIT 1) AS `dotimeandusers` 
			FROM
			  `case_device_repair` r 
			  INNER JOIN `case_device_buildingtype` build 
			    ON r.`build` = build.`id` 
			  INNER JOIN `case_device_building_floor` fl 
			    ON fl.`id` = r.`floor` 
			  INNER JOIN `case_device_building_floor_area` ar 
			    ON ar.`id` = r.`area` 
			  INNER JOIN `case_device_type` mt 
			    ON r.`type` = mt.`id` 
			  INNER JOIN `case_device_child_type` ct 
			    ON r.`childtype` = ct.`id` 
			  LEFT JOIN `case_device_repair_dispatch` disp 
			    ON r.`id` = disp.`repair` ";
        $repair = M('case_device_repair');
        $case = $_SESSION['case'];
        $sql .= "WHERE r.`case` = " . $case;
        if (! empty($state)) {
            $sql .= " AND r.state= '" . $state . "'";
        }
        if (! empty($devicename)) {
            $sql .= " AND r.devicename like '%" . $devicename . "%'";
            $this->assign("devicename", $devicename);
        }
        if (! empty($repaircode)) {
            $sql .= " AND r.repaircode like '%" . $repaircode . "%'";
            $this->assign("repaircode", $repaircode);
        }
        if (! empty($askman)) {
            $sql .= " AND r.requestuser like '%" . $askman . "%'";
            $this->assign("askman", $askman);
        }
        if (! empty($sdispatcher)) {
            $sql .= " AND disp.dousersname like '%" . $sdispatcher . "%'";
            $this->assign("sdispatcher", $sdispatcher);
        }
        if (! empty($sdate)) {
            $sql .= " AND r.repairdate>= '" . $sdate . "'";
            $this->assign("sdate", $sdate);
        }
        if (! empty($edate)) {
            $sql .= " AND r.repairdate< '" . $edate . " 23:59:59'";
            $this->assign("edate", $edate);
        }
        
        if (! empty($build)) {
            $sql .= " AND r.build= '" . $build . "'";
            $this->assign("build", $build);
        }
        if (! empty($floor)) {
            $sql .= " AND r.floor= '" . $floor . "'";
            $this->assign("floor", $floor);
        }
        if (! empty($area)) {
            $sql .= " AND r.area= '" . $area . "'";
            $this->assign("area", $area);
        }
        if (! empty($deivcetype)) {
            $sql .= " AND r.type= '" . $deivcetype . "'";
            $this->assign("type", $deivcetype);
        }
        if (! empty($devicechildtype)) {
            $sql .= " AND r.childtype= '" . $devicechildtype . "'";
            $this->assign("childtype", $devicechildtype);
        }
        
        $list = $repair->query($sql);
        $downName = '叫修列表';
        $headers = '叫修人,申請人,叫修單編號,叫修日期,樓層區域,主類,子類,設備編號,設備名稱,留言,完工情況';
        
        $this->cvsDown($list, $headers, $downName);
    }

    function PrintRepair()
    {
        // 查询叫修
        $id = $_GET['id'];
        $repair = M('case_device_repair');
        $sql = "SELECT 
				  r.*,c.name caseName,
				  t.`name` AS tname,
				  ct.`name` AS ctname,
				  bt.`name` bname,
				  bf.`name` AS bfname,
				  a.`name` AS aname 
				FROM
				  `case_device_repair` r 
				  INNER JOIN case_device_type t 
				    ON r.`type` = t.`id` 
				  INNER JOIN case_device_child_type ct 
				    ON ct.`id` = r.`childtype` 
				  INNER JOIN case_device_buildingtype bt 
				    ON bt.`id` = r.`build` 
				  INNER JOIN case_device_building_floor bf 
				    ON bf.`id` = r.`floor` 
				  INNER JOIN `case_device_building_floor_area` a 
				    ON a.id = r.`area` 
				  INNER JOIN `case` c ON c.`id`=r.`case`  WHERE r.id=" . $id;
        $data = $repair->query($sql);
        $this->assign("repair", $data[0]);
        $msgs = self::queryRepairMsgNoPager($data, $id);
        $this->assign("msgs", $msgs);
        $this->display('repairPrint');
    }

    function addRepair()
    {
        // 查詢主類別
        $t = M('case_device_type');
        $types = $t->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("types", $types);
        // 查詢東別
        $b = M('case_device_buildingtype');
        $builds = $b->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("builds", $builds);
        $this->assign("linecode", getCaseRepairLineCode($_SESSION['case']));
        $devicecode = $_GET['devicecode'];
        $sql = "select * from case_device where devicecode='$devicecode'";
        $device = $b->query($sql);
        $this->assign("device", $device[0]);
        $this->display('addRepair');
    }

    function insertRepair()
    {
        $repair = M('case_device_repair');
        $data = $repair->create();
        import("ORG.Net.UploadFile");
        $up = new UploadFile();
        $up->savePath = ATTCHEMENT_PATH_CASEFILE;
        $up->saveRule = 'uniqid';
        $up->uploadReplace = true;
        if ($up->upload()) {
            $files = $up->getUploadFileInfo();
            $data['atts'] = $files[0]["savename"];
        }
        $repair->add($data);
        
        $this->repair();
    }

    function repairView()
    {
        // 查询叫修
        $id = $_GET['id'];
        $repair = M('case_device_repair');
        $sql = "SELECT 
			  r.*,
			  t.`name` AS tname,
			  ct.`name` AS ctname,
			  bt.`name` bname,
			  bf.`name` AS bfname,
			  a.`name` AS aname 
			FROM
			  `case_device_repair` r 
			  LEFT JOIN case_device_type t 
			    ON r.`type` = t.`id` 
			  LEFT JOIN case_device_child_type ct 
			    ON ct.`id` = r.`childtype` 
			  LEFT JOIN case_device_buildingtype bt 
			    ON bt.`id` = r.`build` 
			  LEFT JOIN case_device_building_floor bf 
			    ON bf.`id` = r.`floor` 
			  LEFT JOIN `case_device_building_floor_area` a 
			    ON a.id = r.`area`  WHERE r.id=" . $id;
        $data = $repair->query($sql);
        $this->assign("repair", $data[0]);
        $this->queryRepairMsg($data, $id);
        
        $this->display('repairView');
    }

    /**
     *
     * @param
     *            data
     */
    private function queryRepairMsg($data, $id)
    {
        // 查询派工
        $dispatch = M('case_device_repair_dispatch');
        $disp = $dispatch->where('repair = ' . $id)->find();
        $this->assign('dispatch', $disp);
        // 查询委外
        $delegate = M('case_device_repair_delegate');
        $dele = $delegate->where('repair = ' . $id)->find();
        $this->assign('delegate', $dele);
        // 查询完工
        $complete = M('case_device_repair_complete');
        $comp = $complete->where('repair = ' . $id)->find();
        $this->assign('complete', $comp);
        
        // 組合固定留言
        $fixedmsgs = array(
            array(
                'senddate' => $data[0]['repairdate'],
                'senduser' => $data[0]['requestuser'],
                'msg' => $data[0]['remark'],
                'msgtype' => '叫修'
            )
        );
        // array ('senddate' => $disp [0] ['dispatchdate'], 'senduser' => $disp
        // [0] ['dispatchuser'], 'msg' => $disp [0] ['doremark'], 'msgtype' =>
        // '派工' ),
        // array ('senddate' => $dele [0] ['delegatedate'], 'senduser' => $dele
        // [0] ['delegateuser'], 'msg' => $dele [0] ['remark'], 'msgtype' =>
        // '委外' ),
        // array ('senddate' => $comp [0] ['completedate'], 'senduser' => $comp
        // [0] ['replayuser'], 'msg' => $comp [0] ['completeremark'], 'msgtype'
        // => '完工' )
        if (! empty($disp)) {
            array_push($fixedmsgs, array(
                'senddate' => $disp['dispatchdate'],
                'senduser' => $disp['dispatchuser'],
                'msg' => $disp['doremark'],
                'msgtype' => '派工'
            ));
        }
        if (! empty($dele)) {
            array_push($fixedmsgs, array(
                'senddate' => $dele['delegatedate'],
                'senduser' => $dele['delegateuser'],
                'msg' => $dele['remark'],
                'msgtype' => '委外'
            ));
        }
        if (! empty($comp)) {
            array_push($fixedmsgs, array(
                'senddate' => $comp['completedate'],
                'senduser' => $comp['replayuser'],
                'msg' => $comp['completeremark'],
                'msgtype' => '完工'
            ));
        }
        // 查詢留言
        
        import("ORG.Util.Page");
        $message = M('case_device_repair_message');
        
        $mess = $message->where('repair = ' . $id)->select();
        
        $count = $message->where('repair = ' . $id)->count();
        $count = $count + 4;
        $p = $this->getPage($count);
        $page = $p->show();
        // $list = $message->where ( 'repair = ' . $id )->order ( 'id desc'
        // )->limit ( $p->firstRow . ','.$p->listRows )->select ();
        if ($p->firstRow == 0) {
            $list = $message->where('repair = ' . $id)
                ->order('id desc')
                ->limit($p->firstRow . ', 6')
                ->select();
        } else {
            $list = $message->where('repair = ' . $id)
                ->order('id desc')
                ->limit(($p->firstRow - 4) . ',' . $p->listRows)
                ->select();
        }
        $this->assign("page", $page);
        if ($p->firstRow == 0) {
            if (count($list) > 0)
                $this->assign("msgs", array_merge($fixedmsgs, $list));
            else
                $this->assign("msgs", $fixedmsgs);
        } 

        else
            $this->assign("msgs", $list);
    }

    private function queryRepairMsgNoPager($data, $id)
    {
        // 查询派工
        $dispatch = M('case_device_repair_dispatch');
        $disp = $dispatch->where('repair = ' . $id)->find();
        // 查询委外
        $delegate = M('case_device_repair_delegate');
        $dele = $delegate->where('repair = ' . $id)->find();
        // 查询完工
        $complete = M('case_device_repair_complete');
        $comp = $complete->where('repair = ' . $id)->find();
        // 組合固定留言
        $fixedmsgs = array(
            array(
                'senddate' => $data[0]['repairdate'],
                'senduser' => $data[0]['requestuser'],
                'msg' => $data[0]['remark'],
                'msgtype' => '叫修'
            )
        );
        if (! empty($disp)) {
            array_push($fixedmsgs, array(
                'senddate' => $disp['dispatchdate'],
                'senduser' => $disp['dispatchuser'],
                'msg' => $disp['doremark'],
                'msgtype' => '派工'
            ));
        }
        if (! empty($dele)) {
            array_push($fixedmsgs, array(
                'senddate' => $dele['delegatedate'],
                'senduser' => $dele['delegateuser'],
                'msg' => $dele['remark'],
                'msgtype' => '委外'
            ));
        }
        if (! empty($comp)) {
            array_push($fixedmsgs, array(
                'senddate' => $comp['completedate'],
                'senduser' => $comp['replayuser'],
                'msg' => $comp['completeremark'],
                'msgtype' => '完工'
            ));
        }
        // 查詢留言
        
        $message = M('case_device_repair_message');
        
        $mess = $message->where('repair = ' . $id)->select();
        
        if (! empty($mess))
            return array_merge($fixedmsgs, $mess);
        else
            return $fixedmsgs;
    }

    function addRepairViewMessage()
    {
        $m = M('case_device_repair_message');
        $m->create();
        $m->add();
        $this->repairView();
    }

    function addDelegateRemark()
    {
        $repair = M('case_device_repair');
        $sql = "SELECT r.*,t.`name` AS tname ,ct.`name` AS ctname, bt.`name` bname ,bf.`name` AS bfname,a.`name` AS aname FROM `case_device_repair` r INNER JOIN case_device_type t ON r.`type`=t.`id` INNER JOIN case_device_child_type ct ON ct.`id`=r.`childtype` INNER JOIN case_device_buildingtype bt ON bt.`id`=r.`build` INNER JOIN case_device_building_floor bf ON bf.`id`=r.`floor` INNER JOIN  `case_device_building_floor_area` a ON a.id=r.`area` WHERE r.id=" . $_GET['id'];
        $data = $repair->query($sql);
        $this->assign("repair", $data[0]);
        $this->display('addDelegateRemark');
    }

    function updateDelegateRemark()
    {
        $repair = M('case_device_repair');
        $repair->create();
        $repair->save();
        $this->repair();
    }

    function CancelRepair()
    {
        $repair = M('case_device_repair');
        $data['state'] = '取消';
        $repair->where('id=' . $_GET['id'])->save($data);
        $this->repair();
    }

    function DeleteRepair()
    {
        $repair = M('case_device_repair');
        $repair->delete($_GET['id']);
        $this->redirect('Case/repair');
    }

    function doRepair()
    {
        // 查询叫修列表
        $repair = M('case_device_repair');
        $sql = "SELECT * FROM case_device_repair where state='申請叫修' AND `case`=" . $_SESSION['case'] . " order by id desc";
        $repairs = $repair->query($sql);
        $this->assign('repairs', $repairs);
        // 查询部门
        // $depart = new DepartModel ();
        // $departs = $depart->selectByCode ();
        // $this->assign ( "departs", $departs );
        $sql = "SELECT u.* FROM case_member cm INNER JOIN `user` u ON cm.`memberid`=u.`id` WHERE cm.`case`=" . $_SESSION['case'];
        $users = $repair->query($sql);
        $this->assign("users", $users);
        
        $this->assign("nowdate", date('Y/m/d H:i:s'));
        $this->display('doRepair');
    }

    function getRepair()
    {
        $id = $_POST['id'];
        $repair = M('case_device_repair');
        $sql = "SELECT 
			  r.*,
			  t.`name` AS tname,
			  ct.`name` AS ctname,
			  bt.`name` bname,
			  bf.`name` AS bfname,
			  a.`name` AS aname ,
			  dp.`dostartdate`,
			  dp.`dostarthour`,
			  dp.`dostartminute`,
			  dp.`doenddate`,
			  dp.`doendhour`,
			  dp.`doendminute`,
			  dp.`dousersname`
			FROM
			  `case_device_repair` r 
			  INNER JOIN case_device_type t 
			    ON r.`type` = t.`id` 
			  INNER JOIN case_device_child_type ct 
			    ON ct.`id` = r.`childtype` 
			  INNER JOIN case_device_buildingtype bt 
			    ON bt.`id` = r.`build` 
			  INNER JOIN case_device_building_floor bf 
			    ON bf.`id` = r.`floor` 
			  INNER JOIN `case_device_building_floor_area` a 
			    ON a.id = r.`area` 
			   LEFT JOIN case_device_repair_dispatch dp
			   ON dp.`repair`=r.`id` WHERE r.id=" . $id;
        $data = $repair->query($sql);
        $data[0]['msg'] = $this->queryRepairMsgNoPager($data, $id);
        echo json_encode($data[0]);
    }

    function addDoRepair()
    {
        $do = M('case_device_repair_dispatch');
        try {
            $do->startTrans();
            $data = $do->create();
            $do->add($data);
            // 更新狀態
            $repair = M('case_device_repair');
            $d['state'] = '派工';
            $repair->where('id=' . $data['repair'])->save($d);
            $do->commit();
        } catch (Exception $e) {
            $do->rollback();
        }
        
        $this->repair();
    }

    function repairFinish()
    {
        // 查询叫修列表
        $repair = M('case_device_repair');
        $sql = "SELECT * FROM case_device_repair where (state='派工' or state='委外') AND `case`=" . $_SESSION['case'] . " order by id desc";
        ;
        $repairs = $repair->query($sql);
        $this->assign('repairs', $repairs);
        // // 查询部门
        // $depart = new DepartModel ();
        // $departs = $depart->selectByCode ();
        // $this->assign ( "departs", $departs );
        $sql = "SELECT u.* FROM case_member cm INNER JOIN `user` u ON cm.`memberid`=u.`id` WHERE cm.`case`=" . $_SESSION['case'];
        $users = $repair->query($sql);
        $this->assign("users", $users);
        
        $this->display('repairFinish');
    }

    function addRepairFinish()
    {
        $finish = M('case_device_repair_complete');
        try {
            $finish->startTrans();
            $data = $finish->create();
            import("ORG.Net.UploadFile");
            $up = new UploadFile();
            $up->savePath = ATTCHEMENT_PATH_CASEFILE;
            $up->saveRule = 'uniqid';
            $up->uploadReplace = true;
            $paths = "";
            if ($up->upload()) {
                $files = $up->getUploadFileInfo();
                for ($i = 0; $i <= count($files); $i ++) {
                    $paths = $paths . $files[$i]["savename"];
                    if ($i < count($files) - 1)
                        $paths = $paths . ",";
                }
                $data['atts'] = $paths;
            } else {
                // echo $up->getErrorMsg ();
            }
            $ret = $finish->add($data);
            $this->checkExcept($ret);
            // 更新狀態
            $repair = M('case_device_repair');
            $d['state'] = '完工';
            $ret = $repair->where('id=' . $data['repair'])->save($d);
            $this->checkExcept($ret);
            // 完工回報的資料送出後，請把這個叫修完工的工作，直接寫到實際工作人員的工作日誌中
            $dotimeandusers = $data['dotimeandusers'];
            if (! empty($dotimeandusers)) {
                $utarray = explode(',', $dotimeandusers);
                if (! empty($utarray)) {
                    foreach ($utarray as $ut) {
                        $user = csubstr($ut, 0, strpos($ut, '/') - 1);
                        $dates = csubstr($ut, strpos($ut, '/') + 1, strlen($ut) - strpos($ut, '/'));
                        $dateArr = explode("~", $dates);
                        $sdate = trim($dateArr[0]);
                        $edate = trim($dateArr[1]);
                        $shour = csubstr($sdate, 11, 2);
                        $sminute = csubstr($sdate, 14, 2);
                        $ehour = csubstr($edate, 11, 2);
                        $eminute = csubstr($edate, 14, 2);
                        $overday = (strtotime($edate) - strtotime($sdate)) / 3600 * 24 > 0 ? 1 : 0;
                        $sql = "SELECT * FROM `user` WHERE concat(name,'(',ucode,')')='$user'";
                        $udata = $finish->query($sql);
                        if (count($udata) > 0) {
                            $worklog = M('work');
                            $work['date'] = $sdate; // $_POST ['completedate'];
                            $work['typename'] = '故障維修';
                            $work['description'] = $_POST['jxcode'] . ',' . $_POST['sbtype'] . ',' . $_POST['sbcode'] . ',' . $_POST['sbname'];
                            $work['status'] = '完成工作';
                            $work['overday'] = $overday;
                            $work['awoke'] = 0;
                            $work['uid'] = $udata[0]['id'];
                            $work['code'] = $this->code;
                            $work['shour'] = $shour;
                            $work['sminute'] = $sminute;
                            $work['ehour'] = $ehour;
                            $work['eminute'] = $eminute;
                            $ret = $worklog->add($work);
                            $this->checkExcept($ret);
                        }
                    }
                }
            }
            // 同時完工後，請系統發訊息到申請人的一般訊息
            $repairData = $repair->find($data['repair']);
            $cont = $data['dotimeandusers'] . " 完成" . $repairData['repaircode'] . "之叫修單的工作。<br> 完工說明如下：" . $data['completeremark'];
            $msg = M("msg");
            $msgData['senderid'] = $this->getId();
            $msgData['sendername'] = $this->getName();
            $msgData['receiversid'] = $repairData['requestuserid'];
            $msgData['receiversname'] = $repairData['requestuser'];
            $msgData['title'] = date("Y年m月d日", strtotime($data['completedate'])) . "完工回报";
            $msgData['cont'] = $cont;
            $msgData['senddate'] = date("Y/m/d h:i:s");
            $msgData['code'] = $this->getCode();
            $ret = $msg->add($msgData);
            $this->checkExcept($ret);
            // 发送邮件
            $user = M('user');
            $username = $repairData['requestuser'];
            $userData = $user->where("name='$username'")->find();
            if (! empty($userData)) {
                // 开始发送邮件
                $name = $userData['name'];
                $to = $userData['email'];
                $subject = date("Y年m月d日", strtotime($data['completedate'])) . "完工回报";
                $body = $cont;
                if (! empty($paths)) {
                    $atts = explode(',', $paths);
                    $this->send_email(array(
                        $to
                    ), $subject, $body, $atts);
                } else {
                    $this->send_email(array(
                        $to
                    ), $subject, $body);
                }
            }
            $finish->commit();
        } catch (Exception $e) {
            $finish->rollback();
        }
        
        $this->repair();
    }

    function delegateRepair()
    {
        import("ORG.Util.Page");
        // 查詢設備
        $sql = "SELECT rd.*,r.`repaircode` FROM `case_device_repair_delegate` rd INNER JOIN case_device_repair r ON rd.`repair`=r.id ";
        $state = $_POST['state'];
        $repaircode = $_POST['repaircode'];
        $manufactures = $_POST['manufactures'];
        if (! empty($manufactures)) {
            $sql .= " AND rd.manufactures like '%" . $manufactures . "%'";
        }
        if (! empty($state)) {
            $sql .= " AND rd.state='" . $state . "'";
        }
        if (! empty($repaircode)) {
            $sql .= " AND r.repaircode='" . $repaircode + "'";
        }
        $delegate = new Model();
        $list = $delegate->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $delegate->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('delegateRepair');
    }

    function addDelegateRepair()
    {
        
        // 查询叫修列表
        $repair = M('case_device_repair');
        $sql = "SELECT * FROM case_device_repair where state='申請叫修' AND `case`=" . $_SESSION['case'];
        $repairs = $repair->query($sql);
        $this->assign('repairs', $repairs);
        
        $this->display('addDelegateRepair');
    }

    function down()
    {
        $name = $_GET['name'];
        $this->download(ATTCHEMENT_PATH_CASEFILE . $name, $name);
    }

    function inserDelegateRepair()
    {
        $delegate = M('case_device_repair_delegate');
        try {
            $delegate->startTrans();
            $data = $delegate->create();
            import("ORG.Net.UploadFile");
            $up = new UploadFile();
            $up->savePath = ATTCHEMENT_PATH_CASEFILE;
            $up->saveRule = 'uniqid';
            $up->uploadReplace = true;
            if ($up->upload()) {
                $paths = "";
                $files = $up->getUploadFileInfo();
                for ($i = 0; $i <= count($files); $i ++) {
                    $paths = $paths . $files[$i]["savename"];
                    if ($i < count($files) - 1)
                        $paths = $paths . ",";
                }
                $data['atts'] = $paths;
            }
            $data['state'] = '報價';
            $delegate->add($data);
            // 更新狀態
            $repair = M('case_device_repair');
            $d['state'] = '委外';
            $repair->where('id=' . $data['repair'])->save($d);
            $delegate->commit();
        } catch (Exception $e) {
            $delegate->rollback();
        }
        
        $this->delegateRepair();
    }
    // /删除
    function delDelegateRepair()
    {
        $ids = $_POST["itemcheckbox"];
        $where = implode(",", $ids);
        $model = M('case_device_repair_delegate');
        $model->delete($where);
        $this->delegateRepair();
    }
    // 议价
    function bidDelegateRepair()
    {
        $ids = $_POST["itemcheckbox"];
        $where = "id in (" . implode(",", $ids) . ")";
        $model = M('case_device_repair_delegate');
        $model->where($where)->save(array(
            'state' => '議價'
        ));
        $this->delegateRepair();
    }
    // 成交
    function clibchDelegateRepair()
    {
        $ids = $_POST["itemcheckbox"];
        $where = "id in (" . implode(",", $ids) . ")";
        $model = M('case_device_repair_delegate');
        $model->where($where)->save(array(
            'state' => '成交'
        ));
        $this->delegateRepair();
    }
    
    // 工程报价
    function projectBid()
    {
        import("ORG.Util.Page");
        $where = " `case` = " . $_SESSION['case'];
        $clientname = $_POST['cname'];
        $state = $_POST['sstate'];
        $date = $_POST['ddate'];
        if (! empty($clientname))
            $where .= " AND clientname like '%" . $clientname . "%'";
        if (! empty($state))
            $where .= " AND state ='" . $state . "'";
        if (! empty($date))
            $where .= " AND DATEDIFF('" . $date . "',biddate)=0";
        
        $bid = M('case_device_project_bid');
        $count = $bid->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $bid->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display('projectBid');
    }

    function addBid()
    {
        parent::getDeparts();
        $this->display('addBid');
    }

    function addProjectBid()
    {
        $bid = M('case_device_project_bid');
        $data = $bid->create();
        if (empty($data['id']))
            $bid->add($data);
        else
            $bid->save($data);
        $this->projectBid();
    }

    function editBid()
    {
        $b = M('case_device_project_bid');
        $bid = $b->find($_GET['id']);
        $this->assign('bid', $bid);
        parent::getDeparts();
        $this->display('editBid');
    }

    function deleteBid()
    {
        $dt = M('case_device_project_bid');
        $dt->delete($_GET['id']);
        $this->projectBid();
    }

    function attendance()
    {
        $model = M('case_attendance');
        import("ORG.Util.Page");
        $where = "`case` = " . $_SESSION['case'];
        $state = $_POST['state'];
        $syear = $_POST['syear'];
        $eyear = $_POST['eyear'];
        $smonth = $_POST['smonth'];
        $emonth = $_POST['emonth'];
        if (! empty($state)) {
            $where .= " and state='" . $state . "'";
        }
        if (! empty($syear)) {
            $where .= " and year>='" . $syear . "'";
        }
        if (! empty($syear)) {
            $where .= " and year<='" . $syear . "'";
        }
        if (! empty($smonth)) {
            $where .= " and month>='" . $smonth . "'";
        }
        if (! empty($emonth)) {
            $where .= " and month<='" . $emonth . "'";
        }
        $count = $model->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $model->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display('attendance');
    }

    function attendanceImport()
    {
        
        // 縣上傳EXCEL
        import("ORG.Net.UploadFile");
        $up = new UploadFile();
        $up->savePath = ATTCHEMENT_PATH_CASEFILE;
        $up->saveRule = 'uniqid';
        $up->uploadReplace = true;
        if ($up->upload()) {
            $files = $up->getUploadFileInfo();
            $path = $files[0]["savename"];
            // 導入數據
            vendor('Excel.PHPExcel');
            $filename = BASEPATH . "/Public/Uploads/atts/case/" . $path;
            chmod($filename, 0777);
            $objPHPExcel = PHPExcel_IOFactory::load($filename);
            $rows = $objPHPExcel->getSheet(0)->getRowDimensions();
            spl_autoload_register(array(
                'Think',
                'autoload'
            ));
            $attend = M('case_attendance');
            try {
                $attend->startTrans();
                $att = $attend->create();
                $sql = "SELECT * FROM `case_attendance` WHERE year=" . $att['year'] . " AND month=" . $att['month'] . " AND `case` =" . $att['case'];
                $oldAtt = $attend->query($sql);
                if (! empty($oldAtt)) {
                    $id = $oldAtt[0]['id'];
                    $sql = "DELETE FROM `case_attendance_detail` WHERE `attendance` =" . $id;
                    $attend->execute($sql);
                } else {
                    $id = $attend->add($att);
                }
                
                for ($i = 3; $i < count($rows); $i ++) {
                    $userid = $objPHPExcel->getSheet(0)
                        ->getCellByColumnAndRow(0, $i)
                        ->getValue();
                    $username = $objPHPExcel->getSheet(0)
                        ->getCellByColumnAndRow(1, $i)
                        ->getValue();
                    
                    for ($j = 2; $j < 33; $j ++) {
                        $v = $objPHPExcel->getSheet(0)
                            ->getCellByColumnAndRow($j, $i)
                            ->getValue();
                        $day = $j - 1;
                        if (empty($v))
                            continue;
                        $sql = "INSERT INTO `case_attendance_detail`
						(`id`,
						`attendance`,
						`userid`,
						`username`,
						`day`,
						`workcode`
						)VALUES (NULL,'$id','$userid','$username','$day','$v');";
                        $attend->execute($sql);
                    }
                }
                $attend->commit();
            } catch (Exception $e) {
                $attend->rollback();
            }
            $this->attendance();
        }
    }

    function deleteAttendance()
    {
        $att = M('case_attendance');
        $att->delete($_GET['id']);
        $att->execute("delete from case_attendance_detail where attendance=" . $_GET['id']);
        $this->attendance();
    }

    function attendanceCheck()
    {
        $att = M('case_attendance');
        $id = $_GET['id'];
        $data = $att->find($id);
        
        $detail = M('case_attendance_detail');
        $sql = "SELECT 
			  attendance,
			  userid,
			  username,
			  MAX(IF(`day` = 1, workcode, '')) AS day1,
			  MAX(IF(`day` = 2, workcode, '')) AS day2,
			  MAX(IF(`day` = 3, workcode, '')) AS day3,
			  MAX(IF(`day` = 4, workcode, '')) AS day4,
			  MAX(IF(`day` = 5, workcode, '')) AS day5,
			  MAX(IF(`day` = 6, workcode, '')) AS day6,
			  MAX(IF(`day` = 7, workcode, '')) AS day7,
			  MAX(IF(`day` = 8, workcode, '')) AS day8,
			  MAX(IF(`day` = 9, workcode, '')) AS day9,
			  MAX(IF(`day` = 10, workcode, '')) AS day10,
			  MAX(IF(`day` = 11, workcode, '')) AS day11,
			  MAX(IF(`day` = 12, workcode, '')) AS day12,
			  MAX(IF(`day` = 13, workcode, '')) AS day13,
			  MAX(IF(`day` = 14, workcode, '')) AS day14,
			  MAX(IF(`day` = 15, workcode, '')) AS day15,
			  MAX(IF(`day` = 16, workcode, '')) AS day16,
			  MAX(IF(`day` = 17, workcode, '')) AS day17,
			  MAX(IF(`day` = 18, workcode, '')) AS day18,
			  MAX(IF(`day` = 19, workcode, '')) AS day19,
			  MAX(IF(`day` = 20, workcode, '')) AS day20,
			  MAX(IF(`day` = 21, workcode, '')) AS day21,
			  MAX(IF(`day` = 22, workcode, '')) AS day22,
			  MAX(IF(`day` = 23, workcode, '')) AS day23,
			  MAX(IF(`day` = 24, workcode, '')) AS day24,
			  MAX(IF(`day` = 25, workcode, '')) AS day25,
			  MAX(IF(`day` = 26, workcode, '')) AS day26,
			  MAX(IF(`day` = 27, workcode, '')) AS day27,
			  MAX(IF(`day` = 28, workcode, '')) AS day28,
			  MAX(IF(`day` = 29, workcode, '')) AS day29,
			  MAX(IF(`day` = 30, workcode, '')) AS day30,
			  MAX(IF(`day` = 31, workcode, '')) AS day31
			FROM
			  case_attendance_detail  WHERE attendance= $id
			GROUP BY userid,
			  username,
			  attendance ";
        $detais = $detail->query($sql);
        $this->assign("attendance", $data);
        $this->assign("details", $detais);
        for ($i = 0; $i < 31; $i ++) {
            if ($i < 9)
                $dates[$i] = $data['year'] . "-" . $data['month'] . "-0" . ($i + 1);
            else
                $dates[$i] = $data['year'] . "-" . $data['month'] . "-" . ($i + 1);
            $days[$i] = $i + 1;
        }
        // 设置时间
        $this->assign("dates", $dates);
        $this->assign("year", $data['year']);
        $this->assign("month", $data['month']);
        $this->display('attendanceCheck');
    }

    function attendanceAudit()
    {
        $id = $_GET['id'];
        $dao = new Model();
        $dao->execute("UPDATE case_attendance SET state='已審核' WHERE id=$id");
        $this->redirect("attendance");
    }

    function attendanceImportAgain()
    {
        
        // 縣上傳EXCEL
        import("ORG.Net.UploadFile");
        $up = new UploadFile();
        $up->savePath = ATTCHEMENT_PATH_CASEFILE;
        $up->saveRule = 'uniqid';
        $up->uploadReplace = true;
        if ($up->upload()) {
            $files = $up->getUploadFileInfo();
            $path = $files[0]["savename"];
            // 導入數據
            vendor('Excel.PHPExcel');
            $filename = BASEPATH . "/Public/Uploads/atts/case/" . $path;
            chmod($filename, 0777);
            $objPHPExcel = PHPExcel_IOFactory::load($filename);
            $rows = $objPHPExcel->getSheet(0)->getRowDimensions();
            spl_autoload_register(array(
                'Think',
                'autoload'
            ));
            $id = $_GET['id'];
            $attend = M('case_attendance');
            try {
                $attend->startTrans();
                $attend->execute("delete from case_attendance_detail WHERE attendance=$id");
                for ($i = 3; $i < count($rows); $i ++) {
                    $userid = $objPHPExcel->getSheet(0)
                        ->getCellByColumnAndRow(0, $i)
                        ->getValue();
                    $username = $objPHPExcel->getSheet(0)
                        ->getCellByColumnAndRow(1, $i)
                        ->getValue();
                    
                    for ($j = 2; $j < 33; $j ++) {
                        $v = $objPHPExcel->getSheet(0)
                            ->getCellByColumnAndRow($j, $i)
                            ->getValue();
                        $day = $j - 1;
                        if (empty($v))
                            continue;
                        $sql = "INSERT INTO `case_attendance_detail`
								(`id`,
								`attendance`,
								`userid`,
								`username`,
								`day`,
								`workcode`
								)VALUES (NULL,'$id','$userid','$username','$day','$v');";
                        $attend->execute($sql);
                    }
                }
                $attend->commit();
            } catch (Exception $e) {
                $attend->rollback();
            }
            $case = $_SESSION['case'];
            $this->redirect("attendanceCheck?case=$case&id=$id");
        }
    }

    function costanalysis()
    {
        $case = $_SESSION['case'];
        $user = $_POST['username'];
        $syear = $_POST['syear'];
        $eyear = $_POST['eyear'];
        $smonth = $_POST['smonth'];
        $emonth = $_POST['emonth'];
        if (! empty($user)) {
            $where .= " and u.name like '%" . $user . "%'";
        }
        if (! empty($syear)) {
            $where .= " and att.year>='" . $syear . "'";
        }
        if (! empty($syear)) {
            $where .= " and att.year<='" . $syear . "'";
        }
        if (! empty($smonth)) {
            $where .= " and att.month>='" . $smonth . "'";
        }
        if (! empty($emonth)) {
            $where .= " and att.month<='" . $emonth . "'";
        }
        $sql = "SELECT 
			  att.`year`,
			  att.`month`,
			  u.`ucode`,
			  u.`name`,
			  u.id AS uid ,
			  cm.`salary`,
			  ROUND(SUM(cw.salary * cm.salary)) AS total
			FROM
			  case_attendance att 
			  INNER JOIN case_attendance_detail attdetail 
			    ON att.`id` = attdetail.`attendance` 
			  INNER JOIN case_member cm 
			    ON cm.`memberid` = attdetail.`userid` 
			  INNER JOIN `user` u 
			    ON u.`id` = attdetail.`userid` 
			   INNER JOIN case_work cw ON cw.`workcode`=attdetail.`workcode`
			WHERE att.`case` = $case.$where 
			GROUP BY  u.id ";
        $sql .= $where;
        $m = new Model();
        $datas = $m->query($sql);
        $tt = 0;
        foreach ($datas as $k => $v) {
            $tt += $datas[$k]['total'];
        }
        $this->assign('list', $datas);
        $this->assign("tt", $tt);
        $this->display('costanalysis');
    }

    function costanalysisperson()
    {
        $m = M('case_member');
        $case = $_SESSION['case'];
        $memberid = $_GET['memberid'];
        $year = $_GET['year'];
        $month = $_POST['month'];
        if (empty($month))
            $month = $_GET['month'];
        $sql = "SELECT m.*,u.`name`,u.`ucode`,t.`name` AS tname FROM case_member m  INNER JOIN `user` u ON u.`id`=m.`memberid` INNER JOIN case_team t ON t.`id`=m.`teamid` ";
        $sql .= "WHERE " . "m.`case`=" . $_SESSION['case'] . " and memberid=" . $_GET['memberid'];
        $members = $m->query($sql);
        $this->assign('member', $members[0]);
        
        $sql = "SELECT 
			  att.`year`,
			  att.`month`,
			  attdetail.`workcode`,
			  u.`ucode`,
			  u.`name`,
			  u.id AS uid ,
			  cm.`salary`,
			  cw.`salary` AS basic,
			  ROUND(SUM(cw.salary * cm.salary)) AS total,
			  COUNT(attdetail.id) AS tcount
			FROM
			  case_attendance att 
			  INNER JOIN case_attendance_detail attdetail 
			    ON att.`id` = attdetail.`attendance` 
			  INNER JOIN case_member cm 
			    ON cm.`memberid` = attdetail.`userid` 
			  INNER JOIN `user` u 
			    ON u.`id` = attdetail.`userid` 
			   INNER JOIN case_work cw ON cw.`workcode`=attdetail.`workcode`
			WHERE  att.`case`=$case AND att.`year`='$year' AND att.`month`='$month' AND attdetail.`userid`=$memberid
			GROUP BY  
			  attdetail.`workcode`,
			  u.id";
        
        $datas = $m->query($sql);
        $tt = 0;
        foreach ($datas as $k => $v) {
            $tt += $datas[$k]['total'];
        }
        $this->assign('list', $datas);
        $this->assign("tt", $tt);
        $this->display('costanalysisperson');
    }

    function statisticsbymonth()
    {
        $case = $_POST['case'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        if (empty($case))
            $case = $_SESSION['case'];
        if (empty($year))
            $year = date('Y');
        if (empty($month))
            $month = date('m');
            // 明细sql
        $sql = "SELECT 
			 *,
			  day1 + day2 + day3 + day4 + day5 + day6 + day7 + day8 + day9 + day10 + day11 + day12 + day13 + day14 + day15 + day16 + + day17 + day18 + day19 + day20 + day21 + day22 + day23 + day24 + day25 + day26 + day27 + day28 + day29 + day30 + day31 AS rt 
			FROM
			  (SELECT st.id,st.n,
			 SUM(IF(DAY(st.t) = 1, st.c, 0)) AS day1,
			 SUM(IF(DAY(st.t) = 2, st.c, 0)) AS day2,
			 SUM(IF(DAY(st.t) = 3, st.c, 0)) AS day3,
			 SUM(IF(DAY(st.t) = 4, st.c, 0)) AS day4,
			 SUM(IF(DAY(st.t) = 5, st.c, 0)) AS day5,
			 SUM(IF(DAY(st.t) = 6, st.c, 0)) AS day6,
			 SUM(IF(DAY(st.t) = 7, st.c, 0)) AS day7,
			 SUM(IF(DAY(st.t) = 8, st.c, 0)) AS day8,
			 SUM(IF(DAY(st.t) = 9, st.c, 0)) AS day9,
			 SUM(IF(DAY(st.t) = 10, st.c, 0)) AS day10,
			 SUM(IF(DAY(st.t) = 11, st.c, 0)) AS day11,
			 SUM(IF(DAY(st.t) = 12, st.c, 0)) AS day12,
			 SUM(IF(DAY(st.t) = 13, st.c, 0)) AS day13,
			 SUM(IF(DAY(st.t) = 14, st.c, 0)) AS day14,
			 SUM(IF(DAY(st.t) = 15, st.c, 0)) AS day15,
			 SUM(IF(DAY(st.t) = 16, st.c, 0)) AS day16,
			 SUM(IF(DAY(st.t) = 17, st.c, 0)) AS day17,
			 SUM(IF(DAY(st.t) = 18, st.c, 0)) AS day18,
			 SUM(IF(DAY(st.t) = 19, st.c, 0)) AS day19,
			 SUM(IF(DAY(st.t) = 20, st.c, 0)) AS day20,
			 SUM(IF(DAY(st.t) = 21, st.c, 0)) AS day21,
			 SUM(IF(DAY(st.t) = 22, st.c, 0)) AS day22,
			 SUM(IF(DAY(st.t) = 23, st.c, 0)) AS day23,
			 SUM(IF(DAY(st.t) = 24, st.c, 0)) AS day24,
			 SUM(IF(DAY(st.t) = 25, st.c, 0)) AS day25,
			 SUM(IF(DAY(st.t) = 26, st.c, 0)) AS day26,
			 SUM(IF(DAY(st.t) = 27, st.c, 0)) AS day27,
			 SUM(IF(DAY(st.t) = 28, st.c, 0)) AS day28,
			 SUM(IF(DAY(st.t) = 29, st.c, 0)) AS day29,
			 SUM(IF(DAY(st.t) = 30, st.c, 0)) AS day30,
			 SUM(IF(DAY(st.t) = 31, st.c, 0)) AS day31
			 FROM (
			SELECT 
			  t.id,t.`name` AS n,
			  DATE(r.repairdate) AS t,
			  COUNT(r.id) AS c 
			FROM
			  `case_device_repair` r 
			  INNER JOIN case_device_type t 
			    ON r.`type` = t.`id` 
			WHERE r.`case` = $case 
			  AND YEAR(r.repairdate) = $year 
			  AND MONTH(r.repairdate) = $month 
			GROUP BY t.id,t.`name`,
			  DATE(r.repairdate) 
			ORDER BY t.`name`,
			  DATE(r.repairdate) 
			  ) st GROUP BY st.n  WITH ROLLUP) f";
        
        $M = new Model();
        $list = $M->query($sql);
        $rowcount = count($list);
        $total = $list[$rowcount - 1]['rt'];
        if ($total > 0) {
            $list[$rowcount - 1]['n'] = '總數';
            for ($i = 0; $i < $rowcount - 1; $i ++) {
                $list[$i]['rb'] = number_format($list[$i]['rt'] * 100 / $total, 1) . '%';
            }
            $list[$rowcount]['n'] = '比例%';
            for ($j = 1; $j < 32; $j ++) {
                $list[$rowcount]['day' . $j] = number_format($list[$rowcount - 1]['day' . $j] * 100 / $total, 1) . '%';
            }
        }
        for ($i = 0; $i < 31; $i ++) {
            if ($i < 10)
                $dates[$i] = $year . "-" . $month . "-0" . ($i + 1);
            else
                $dates[$i] = $year . "-" . $month . "-" . ($i + 1);
        }
        $this->assign('year', $year);
        $this->assign('month', $month);
        $this->assign("rowcount", $rowcount);
        $this->assign("dates", $dates);
        $this->assign('list', $list);
        $this->display('statisticsbymonth');
    }

    function statisticsbymonthDetail()
    {
        $case = $_POST['case'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        if (empty($case))
            $case = $_SESSION['case'];
        if (empty($year))
            $year = date('Y');
        if (empty($month))
            $month = date('m');
            // 明细sql
        $sql = "SELECT * FROM (	
			SELECT 
			 *,
			  day1 + day2 + day3 + day4 + day5 + day6 + day7 + day8 + day9 + day10 + day11 + day12 + day13 + day14 + day15 + day16 + + day17 + day18 + day19 + day20 + day21 + day22 + day23 + day24 + day25 + day26 + day27 + day28 + day29 + day30 + day31 AS rt 
			FROM
			  (SELECT st.mt,st.ct, st.n,st.cn,
			 SUM(IF(DAY(st.t) = 1, st.c, 0)) AS day1,
			 SUM(IF(DAY(st.t) = 2, st.c, 0)) AS day2,
			 SUM(IF(DAY(st.t) = 3, st.c, 0)) AS day3,
			 SUM(IF(DAY(st.t) = 4, st.c, 0)) AS day4,
			 SUM(IF(DAY(st.t) = 5, st.c, 0)) AS day5,
			 SUM(IF(DAY(st.t) = 6, st.c, 0)) AS day6,
			 SUM(IF(DAY(st.t) = 7, st.c, 0)) AS day7,
			 SUM(IF(DAY(st.t) = 8, st.c, 0)) AS day8,
			 SUM(IF(DAY(st.t) = 9, st.c, 0)) AS day9,
			 SUM(IF(DAY(st.t) = 10, st.c, 0)) AS day10,
			 SUM(IF(DAY(st.t) = 11, st.c, 0)) AS day11,
			 SUM(IF(DAY(st.t) = 12, st.c, 0)) AS day12,
			 SUM(IF(DAY(st.t) = 13, st.c, 0)) AS day13,
			 SUM(IF(DAY(st.t) = 14, st.c, 0)) AS day14,
			 SUM(IF(DAY(st.t) = 15, st.c, 0)) AS day15,
			 SUM(IF(DAY(st.t) = 16, st.c, 0)) AS day16,
			 SUM(IF(DAY(st.t) = 17, st.c, 0)) AS day17,
			 SUM(IF(DAY(st.t) = 18, st.c, 0)) AS day18,
			 SUM(IF(DAY(st.t) = 19, st.c, 0)) AS day19,
			 SUM(IF(DAY(st.t) = 20, st.c, 0)) AS day20,
			 SUM(IF(DAY(st.t) = 21, st.c, 0)) AS day21,
			 SUM(IF(DAY(st.t) = 22, st.c, 0)) AS day22,
			 SUM(IF(DAY(st.t) = 23, st.c, 0)) AS day23,
			 SUM(IF(DAY(st.t) = 24, st.c, 0)) AS day24,
			 SUM(IF(DAY(st.t) = 25, st.c, 0)) AS day25,
			 SUM(IF(DAY(st.t) = 26, st.c, 0)) AS day26,
			 SUM(IF(DAY(st.t) = 27, st.c, 0)) AS day27,
			 SUM(IF(DAY(st.t) = 28, st.c, 0)) AS day28,
			 SUM(IF(DAY(st.t) = 29, st.c, 0)) AS day29,
			 SUM(IF(DAY(st.t) = 30, st.c, 0)) AS day30,
			 SUM(IF(DAY(st.t) = 31, st.c, 0)) AS day31
			 FROM (
			SELECT 
			 t.id mt, t.`name` AS n,ct.id ct,ct.name AS cn,
			  DATE(r.repairdate) AS t,
			  COUNT(r.id) AS c 
			FROM
			  `case_device_repair` r 
			  INNER JOIN case_device_type t 
			    ON r.`type` = t.`id` 
			    INNER JOIN `case_device_child_type` 
			    ct ON ct.id=r.childtype
			WHERE r.`case` =$case
			  AND YEAR(r.repairdate) = $year 
			  AND MONTH(r.repairdate) =$month
			GROUP BY t.id, t.`name`,ct.id,ct.name,
			  DATE(r.repairdate) 
			ORDER BY t.`name`,
			  DATE(r.repairdate) 
			  ) st GROUP BY st.n,st.cn  WITH ROLLUP) f) z WHERE z.cn IS NOT NULL OR (z.n IS NULL AND z.cn IS NULL)";
        
        $M = new Model();
        $list = $M->query($sql);
        $rowcount = count($list);
        $total = $list[$rowcount - 1]['rt'];
        if ($total > 0) {
            $list[$rowcount - 1]['n'] = '總數';
            $list[$rowcount - 1]['cn'] = '';
            for ($i = 0; $i < $rowcount - 1; $i ++) {
                $list[$i]['rb'] = number_format($list[$i]['rt'] * 100 / $total, 1) . '%';
            }
            $list[$rowcount]['n'] = '比例%';
            $list[$rowcount]['cn'] = '';
            for ($j = 1; $j < 32; $j ++) {
                $list[$rowcount]['day' . $j] = number_format($list[$rowcount - 1]['day' . $j] * 100 / $total, 1) . '%';
            }
        }
        for ($i = 0; $i < 31; $i ++) {
            if ($i < 10)
                $dates[$i] = $year . "-" . $month . "-0" . ($i + 1);
            else
                $dates[$i] = $year . "-" . $month . "-" . ($i + 1);
        }
        $this->assign('year', $year);
        $this->assign('month', $month);
        $this->assign("rowcount", $rowcount);
        $this->assign("dates", $dates);
        $this->assign('list', $list);
        $this->display('statisticsbymonthDetail');
    }

    function statisticsdetail()
    {
        $case = $_GET['case'];
        $maintype = $_GET['maintype'];
        $childtype = $_GET['childtype'];
        $year = $_GET['year'];
        $month = $_GET['month'];
        $this->assign("action", __SELF__);
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $sql = "SELECT * FROM case_device_repair WHERE  `case` = $case AND type=$maintype AND YEAR(repairdate) = $year ";
            if (! empty($month)) {
                $sql .= " AND MONTH(repairdate) =$month ";
            }
            if (! empty($childtype))
                $sql .= " AND childtype=$childtype ";
            $repair = M('case_device_repair');
            $list = $repair->query($sql);
            $warn = M('case_warn_days');
            $data = $warn->where('`case` = ' . $_SESSION['case'])->find();
            $this->assign('warn', $data);
            $this->assign("list", $list);
            $this->display("statisticsdetail");
        } else {
            $sql = "SELECT 
			  r.`askuser`,
 r.`requestuser`,
  r.`repaircode`,
  r.`repairdate`,
  CONCAT(
    build.`name`,'/',
    fl.`name`,'/',
    ar.`name`
  ) AS region,
  mt.`name` AS mainType,
  ct.`name` AS childType,
  r.`devicecode`,
  r.`devicename`,
  CONCAT(
    IFNULL(r.remark, ''),
    '\n',
    IFNULL(
      (SELECT 
        doremark 
      FROM
        case_device_repair_dispatch 
      WHERE `repair` = r.id 
      LIMIT 1),
      ''
    ),
    '\n',
    IFNULL(
      (SELECT 
        remark 
      FROM
        case_device_repair_delegate 
      WHERE `repair` = r.id 
      LIMIT 1),
      ''
    ),
    '\n',
    IFNULL(
      (SELECT 
        completeremark 
      FROM
        case_device_repair_complete 
      WHERE `repair` = r.id 
      LIMIT 1),
      ''
    ),
    '\n',
    IFNULL(
      (SELECT 
        GROUP_CONCAT(msg) 
      FROM
        `case_device_repair_message` 
      WHERE `repair` = r.id),
      ''
    )
  ) AS msg,
  (SELECT 
    `dotimeandusers` 
  FROM
    `case_device_repair_complete` 
  WHERE `repair` = r.`id` 
  LIMIT 1) AS `dotimeandusers` 
FROM
  `case_device_repair` r 
  LEFT JOIN `case_device_buildingtype` build 
    ON r.`build` = build.`id` 
  LEFT JOIN `case_device_building_floor` fl 
    ON fl.`id` = r.`floor` 
  LEFT JOIN `case_device_building_floor_area` ar 
    ON ar.`id` = r.`area` 
  LEFT JOIN `case_device_type` mt 
    ON r.`type` = mt.`id` 
  LEFT JOIN `case_device_child_type` ct 
    ON r.`childtype` = ct.`id` 
  LEFT JOIN `case_device_repair_dispatch` disp 
    ON r.`id` = disp.`repair`  
			  WHERE r.`case`=$case AND r.`type` =$maintype AND YEAR(r.`repairdate`) = $year";
            if (! empty($month)) {
                $sql .= " AND MONTH(r.repairdate) =$month ";
            }
            if (! empty($childtype))
                $sql .= " AND r.childtype=$childtype ";
            $repair = M('case_device_repair');
            $list = $repair->query($sql);
            $downName = '叫修列表';
            $headers = '叫修人,申請人,叫修單編號,叫修日期,樓層區域,主類,子類,設備編號,設備名稱,留言,完工情況';
            
            $this->cvsDown($list, $headers, $downName);
        }
    }

    function statisticscompletedetail()
    {
        $case = $_GET['case'];
        $maintype = $_GET['maintype'];
        $childtype = $_GET['childtype'];
        $year = $_GET['year'];
        $month = $_GET['month'];
        $this->assign("action", __SELF__);
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $sql = "SELECT r.* FROM case_device_repair r inner join case_device_repair_complete c on r.id=c.`repair` 
					WHERE  `case` = $case 
					AND type=$maintype 
					AND YEAR(repairdate) = $year ";
            if (! empty($month)) {
                $sql .= " AND MONTH(repairdate) =$month ";
            }
            if (! empty($childtype))
                $sql .= " AND childtype=$childtype ";
            $repair = M('case_device_repair');
            $list = $repair->query($sql);
            $warn = M('case_warn_days');
            $data = $warn->where('`case` = ' . $_SESSION['case'])->find();
            $this->assign('warn', $data);
            $this->assign("list", $list);
            $this->display("statisticscompletedetail");
        } else {
            $sql = "SELECT DISTINCT
  r.`askuser`,
  r.`requestuser`,
  r.`repaircode`,
  r.`repairdate`,
  CONCAT(
    build.`name`,'/',
    fl.`name`,'/',
    ar.`name`
  ) AS region,
  mt.`name` AS mainType,
  ct.`name` AS childType,
  r.`devicecode`,
  r.`devicename`,
  CONCAT(
    IFNULL(r.remark, ''),
    '\n',
    IFNULL(
      (SELECT 
        doremark 
      FROM
        case_device_repair_dispatch 
      WHERE `repair` = r.id 
      LIMIT 1),
      ''
    ),
    '\n',
    IFNULL(
      (SELECT 
        remark 
      FROM
        case_device_repair_delegate 
      WHERE `repair` = r.id 
      LIMIT 1),
      ''
    ),
    '\n',
    IFNULL(
      (SELECT 
        completeremark 
      FROM
        case_device_repair_complete 
      WHERE `repair` = r.id 
      LIMIT 1),
      ''
    ),
    '\n',
    IFNULL(
      (SELECT 
        GROUP_CONCAT(msg) 
      FROM
        `case_device_repair_message` 
      WHERE `repair` = r.id),
      ''
    )
  ) AS msg,
  (SELECT 
    `dotimeandusers` 
  FROM
    `case_device_repair_complete` 
  WHERE `repair` = r.`id` 
  LIMIT 1) AS `dotimeandusers` 
FROM
  `case_device_repair` r 
  INNER JOIN `case_device_buildingtype` build 
    ON r.`build` = build.`id` 
  INNER JOIN `case_device_building_floor` fl 
    ON fl.`id` = r.`floor` 
  INNER JOIN `case_device_building_floor_area` ar 
    ON ar.`id` = r.`area` 
  INNER JOIN `case_device_type` mt 
    ON r.`type` = mt.`id` 
  INNER JOIN `case_device_child_type` ct 
    ON r.`childtype` = ct.`id` 
  LEFT JOIN `case_device_repair_dispatch` disp 
    ON r.`id` = disp.`repair`  inner join case_device_repair_complete c on r.id=c.`repair`
			WHERE r.`case`=$case AND r.`type` =$maintype AND YEAR(r.`repairdate`) = $year";
            if (! empty($month)) {
                $sql .= " AND MONTH(r.repairdate) =$month ";
            }
            if (! empty($childtype))
                $sql .= " AND r.childtype=$childtype ";
            $repair = M('case_device_repair');
            $list = $repair->query($sql);
            $downName = '叫修列表';
            $headers = '叫修人,申請人,叫修單編號,叫修日期,樓層區域,主類,子類,設備編號,設備名稱,留言,完工情況';
            
            $this->cvsDown($list, $headers, $downName);
        }
    }

    function statisticsbyyear()
    {
        $case = $_POST['case'];
        $year = $_POST['year'];
        if (empty($case))
            $case = $_SESSION['case'];
        if (empty($year))
            $year = date('Y');
            // 明细sql
        $sql = "SELECT 
				  *,
				  m1 + m2 + m3 + m4 + m5 + m6 + m7 + m8 + m9 + m10 + m11 + m12 AS rt 
				FROM
				  (SELECT 
				    st.id mt,st.n,
				    SUM(IF(st.m = 1, st.c, 0)) AS m1,
				    SUM(IF(st.m = 2, st.c, 0)) AS m2,
				    SUM(IF(st.m = 3, st.c, 0)) AS m3,
				    SUM(IF(st.m = 4, st.c, 0)) AS m4,
				    SUM(IF(st.m = 5, st.c, 0)) AS m5,
				    SUM(IF(st.m = 6, st.c, 0)) AS m6,
				    SUM(IF(st.m = 7, st.c, 0)) AS m7,
				    SUM(IF(st.m = 8, st.c, 0)) AS m8,
				    SUM(IF(st.m = 9, st.c, 0)) AS m9,
				    SUM(IF(st.m = 10, st.c, 0)) AS m10,
				    SUM(IF(st.m = 11, st.c, 0)) AS m11,
				    SUM(IF(st.m = 12, st.c, 0)) AS m12 
				  FROM
				    (SELECT 
				      t.id,t.`name` AS n,
				      MONTH(r.repairdate) AS m,
				      COUNT(r.id) AS c 
				    FROM
				      `case_device_repair` r 
				      INNER JOIN case_device_type t 
				        ON r.`type` = t.`id` 
				    WHERE r.`case` = $case 
				      AND YEAR(r.repairdate) = $year 
				    GROUP BY t.`name`,
				      MONTH(r.repairdate) 
				    ORDER BY t.id, t.`name`) st 
				  GROUP BY st.n WITH ROLLUP) z";
        
        $M = new Model();
        $list = $M->query($sql);
        $rowcount = count($list);
        $total = $list[$rowcount - 1]['rt'];
        if ($total > 0) {
            $list[$rowcount - 1]['n'] = '累計';
            $list[$rowcount - 1]['cn'] = '';
            for ($i = 0; $i < $rowcount - 1; $i ++) {
                $list[$i]['rb'] = number_format($list[$i]['rt'] * 100 / $total, 1) . '%';
            }
            $list[$rowcount]['n'] = '叫修比例%';
            $list[$rowcount]['cn'] = '';
            for ($j = 1; $j < 13; $j ++) {
                $list[$rowcount]['m' . $j] = number_format($list[$rowcount - 1]['m' . $j] * 100 / $total, 1) . '%';
            }
        }
        $this->assign('year', $year);
        $this->assign("rowcount", $rowcount);
        $this->assign('list', $list);
        $this->display('statisticsbyyear');
    }

    function statisticsbyyearDetail()
    {
        $case = $_POST['case'];
        $year = $_POST['year'];
        if (empty($case))
            $case = $_SESSION['case'];
        if (empty($year))
            $year = date('Y');
            // 明细sql
        $sql = "SELECT 
				  *,
				  m1 + m2 + m3 + m4 + m5 + m6 + m7 + m8 + m9 + m10 + m11 + m12 AS rt 
				FROM
				  (SELECT 
				    st.mt,
				    st.ct,
				    st.n,
				    st.cn,
				    SUM(IF(st.m = 1, st.c, 0)) AS m1,
				    SUM(IF(st.m = 2, st.c, 0)) AS m2,
				    SUM(IF(st.m = 3, st.c, 0)) AS m3,
				    SUM(IF(st.m = 4, st.c, 0)) AS m4,
				    SUM(IF(st.m = 5, st.c, 0)) AS m5,
				    SUM(IF(st.m = 6, st.c, 0)) AS m6,
				    SUM(IF(st.m = 7, st.c, 0)) AS m7,
				    SUM(IF(st.m = 8, st.c, 0)) AS m8,
				    SUM(IF(st.m = 9, st.c, 0)) AS m9,
				    SUM(IF(st.m = 10, st.c, 0)) AS m10,
				    SUM(IF(st.m = 11, st.c, 0)) AS m11,
				    SUM(IF(st.m = 12, st.c, 0)) AS m12 
				  FROM
				    (SELECT 
				     t.id mt,ct.id ct, t.`name` AS n,
				      ct.name AS cn,
				      MONTH(r.repairdate) AS m,
				      COUNT(r.id) AS c 
				    FROM
				      `case_device_repair` r 
				      INNER JOIN case_device_type t 
				        ON r.`type` = t.`id` 
				      INNER JOIN `case_device_child_type` ct 
				        ON ct.id = r.childtype 
				    WHERE r.`case` = $case 
				      AND YEAR(r.repairdate) = $year 
				    GROUP BY t.id,ct.id,t.`name`,
				      ct.name,
				      MONTH(r.repairdate) 
				    ORDER BY t.`name`) st 
				  GROUP BY st.n,
				    st.cn WITH ROLLUP) z 
				WHERE z.cn IS NOT NULL 
				  OR (z.n IS NULL 
				    AND z.cn IS NULL)";
        
        $M = new Model();
        $list = $M->query($sql);
        $rowcount = count($list);
        $total = $list[$rowcount - 1]['rt'];
        if ($total > 0) {
            $list[$rowcount - 1]['n'] = '累計';
            $list[$rowcount - 1]['cn'] = '';
            for ($i = 0; $i < $rowcount - 1; $i ++) {
                $list[$i]['rb'] = number_format($list[$i]['rt'] * 100 / $total, 1) . '%';
            }
            $list[$rowcount]['n'] = '叫修比例%';
            $list[$rowcount]['cn'] = '';
            for ($j = 1; $j < 13; $j ++) {
                $list[$rowcount]['m' . $j] = number_format($list[$rowcount - 1]['m' . $j] * 100 / $total, 1) . '%';
            }
        }
        $this->assign('year', $year);
        $this->assign("rowcount", $rowcount);
        $this->assign('list', $list);
        $this->display('statisticsbyyearDetail');
    }

    function statisticsCompletebyMonth()
    {
        $case = $_POST['case'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        if (empty($case))
            $case = $_SESSION['case'];
        if (empty($year))
            $year = date('Y');
        if (empty($month))
            $month = date('m');
            // 明细sql
        $sql = "SELECT 
		  *,
		  day1 + day2 + day3 + day4 + day5 + day6 + day7 + day8 + day9 + day10 + day11 + day12 + day13 + day14 + day15 + day16 + + day17 + day18 + day19 + day20 + day21 + day22 + day23 + day24 + day25 + day26 + day27 + day28 + day29 + day30 + day31 AS rt 
		FROM
		  (SELECT
		  	st.mt,
		    st.n,
		    SUM(IF(DAY(st.t) = 1, st.c, 0)) AS day1,
		    SUM(IF(DAY(st.t) = 2, st.c, 0)) AS day2,
		    SUM(IF(DAY(st.t) = 3, st.c, 0)) AS day3,
		    SUM(IF(DAY(st.t) = 4, st.c, 0)) AS day4,
		    SUM(IF(DAY(st.t) = 5, st.c, 0)) AS day5,
		    SUM(IF(DAY(st.t) = 6, st.c, 0)) AS day6,
		    SUM(IF(DAY(st.t) = 7, st.c, 0)) AS day7,
		    SUM(IF(DAY(st.t) = 8, st.c, 0)) AS day8,
		    SUM(IF(DAY(st.t) = 9, st.c, 0)) AS day9,
		    SUM(IF(DAY(st.t) = 10, st.c, 0)) AS day10,
		    SUM(IF(DAY(st.t) = 11, st.c, 0)) AS day11,
		    SUM(IF(DAY(st.t) = 12, st.c, 0)) AS day12,
		    SUM(IF(DAY(st.t) = 13, st.c, 0)) AS day13,
		    SUM(IF(DAY(st.t) = 14, st.c, 0)) AS day14,
		    SUM(IF(DAY(st.t) = 15, st.c, 0)) AS day15,
		    SUM(IF(DAY(st.t) = 16, st.c, 0)) AS day16,
		    SUM(IF(DAY(st.t) = 17, st.c, 0)) AS day17,
		    SUM(IF(DAY(st.t) = 18, st.c, 0)) AS day18,
		    SUM(IF(DAY(st.t) = 19, st.c, 0)) AS day19,
		    SUM(IF(DAY(st.t) = 20, st.c, 0)) AS day20,
		    SUM(IF(DAY(st.t) = 21, st.c, 0)) AS day21,
		    SUM(IF(DAY(st.t) = 22, st.c, 0)) AS day22,
		    SUM(IF(DAY(st.t) = 23, st.c, 0)) AS day23,
		    SUM(IF(DAY(st.t) = 24, st.c, 0)) AS day24,
		    SUM(IF(DAY(st.t) = 25, st.c, 0)) AS day25,
		    SUM(IF(DAY(st.t) = 26, st.c, 0)) AS day26,
		    SUM(IF(DAY(st.t) = 27, st.c, 0)) AS day27,
		    SUM(IF(DAY(st.t) = 28, st.c, 0)) AS day28,
		    SUM(IF(DAY(st.t) = 29, st.c, 0)) AS day29,
		    SUM(IF(DAY(st.t) = 30, st.c, 0)) AS day30,
		    SUM(IF(DAY(st.t) = 31, st.c, 0)) AS day31 
		  FROM
		    (SELECT 
		      t.id mt,t.`name` AS n,
		      DATE(r.repairdate) AS t,
		      COUNT(r.id) AS c 
		    FROM
		      `case_device_repair` r 
		      INNER JOIN case_device_type t 
		        ON r.`type` = t.`id` 
		      INNER JOIN `case_device_repair_complete` cc 
		        ON r.id = cc.repair 
		    WHERE r.`case` = $case 
		      AND YEAR(r.repairdate) = $year 
		      AND MONTH(r.repairdate) = $month 
		    GROUP BY t.id,t.`name`,
		      DATE(r.repairdate) 
		    ORDER BY t.`name`,
		      DATE(r.repairdate)) st 
		  GROUP BY st.n WITH ROLLUP) f ";
        
        $M = new Model();
        $list = $M->query($sql);
        $rowcount = count($list);
        $total = $list[$rowcount - 1]['rt'];
        if ($total > 0) {
            $list[$rowcount - 1]['n'] = '總數';
            for ($i = 0; $i < $rowcount - 1; $i ++) {
                $list[$i]['rb'] = number_format($list[$i]['rt'] * 100 / $total, 1) . '%';
            }
            $list[$rowcount]['n'] = '比例%';
            for ($j = 1; $j < 32; $j ++) {
                $list[$rowcount]['day' . $j] = number_format($list[$rowcount - 1]['day' . $j] * 100 / $total, 1) . '%';
            }
        }
        for ($i = 0; $i < 31; $i ++) {
            if ($i < 10)
                $dates[$i] = $year . "-" . $month . "-0" . ($i + 1);
            else
                $dates[$i] = $year . "-" . $month . "-" . ($i + 1);
        }
        $this->assign('year', $year);
        $this->assign('month', $month);
        $this->assign("rowcount", $rowcount);
        $this->assign("dates", $dates);
        $this->assign('list', $list);
        $this->display('statisticsCompletebyMonth');
    }

    function statisticsCompletebyMonthDetail()
    {
        $case = $_POST['case'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        if (empty($case))
            $case = $_SESSION['case'];
        if (empty($year))
            $year = date('Y');
        if (empty($month))
            $month = date('m');
            // 明细sql
        $sql = "SELECT 
				  * 
				FROM
				  (SELECT 
				    *,
				    day1 + day2 + day3 + day4 + day5 + day6 + day7 + day8 + day9 + day10 + day11 + day12 + day13 + day14 + day15 + day16 + + day17 + day18 + day19 + day20 + day21 + day22 + day23 + day24 + day25 + day26 + day27 + day28 + day29 + day30 + day31 AS rt 
				  FROM
				    (SELECT 
				      st.mt,
				      st.ct,
				      st.n,
				      st.cn,
				      SUM(IF(DAY(st.t) = 1, st.c, 0)) AS day1,
				      SUM(IF(DAY(st.t) = 2, st.c, 0)) AS day2,
				      SUM(IF(DAY(st.t) = 3, st.c, 0)) AS day3,
				      SUM(IF(DAY(st.t) = 4, st.c, 0)) AS day4,
				      SUM(IF(DAY(st.t) = 5, st.c, 0)) AS day5,
				      SUM(IF(DAY(st.t) = 6, st.c, 0)) AS day6,
				      SUM(IF(DAY(st.t) = 7, st.c, 0)) AS day7,
				      SUM(IF(DAY(st.t) = 8, st.c, 0)) AS day8,
				      SUM(IF(DAY(st.t) = 9, st.c, 0)) AS day9,
				      SUM(IF(DAY(st.t) = 10, st.c, 0)) AS day10,
				      SUM(IF(DAY(st.t) = 11, st.c, 0)) AS day11,
				      SUM(IF(DAY(st.t) = 12, st.c, 0)) AS day12,
				      SUM(IF(DAY(st.t) = 13, st.c, 0)) AS day13,
				      SUM(IF(DAY(st.t) = 14, st.c, 0)) AS day14,
				      SUM(IF(DAY(st.t) = 15, st.c, 0)) AS day15,
				      SUM(IF(DAY(st.t) = 16, st.c, 0)) AS day16,
				      SUM(IF(DAY(st.t) = 17, st.c, 0)) AS day17,
				      SUM(IF(DAY(st.t) = 18, st.c, 0)) AS day18,
				      SUM(IF(DAY(st.t) = 19, st.c, 0)) AS day19,
				      SUM(IF(DAY(st.t) = 20, st.c, 0)) AS day20,
				      SUM(IF(DAY(st.t) = 21, st.c, 0)) AS day21,
				      SUM(IF(DAY(st.t) = 22, st.c, 0)) AS day22,
				      SUM(IF(DAY(st.t) = 23, st.c, 0)) AS day23,
				      SUM(IF(DAY(st.t) = 24, st.c, 0)) AS day24,
				      SUM(IF(DAY(st.t) = 25, st.c, 0)) AS day25,
				      SUM(IF(DAY(st.t) = 26, st.c, 0)) AS day26,
				      SUM(IF(DAY(st.t) = 27, st.c, 0)) AS day27,
				      SUM(IF(DAY(st.t) = 28, st.c, 0)) AS day28,
				      SUM(IF(DAY(st.t) = 29, st.c, 0)) AS day29,
				      SUM(IF(DAY(st.t) = 30, st.c, 0)) AS day30,
				      SUM(IF(DAY(st.t) = 31, st.c, 0)) AS day31 
				    FROM
				      (SELECT 
				      	t.id mt,
				      	ct.id ct,
				        t.`name` AS n,
				        ct.name AS cn,
				        DATE(r.repairdate) AS t,
				        COUNT(r.id) AS c 
				      FROM
				        `case_device_repair` r 
				        INNER JOIN case_device_type t 
				          ON r.`type` = t.`id` 
				        INNER JOIN `case_device_child_type` ct 
				          ON ct.id = r.childtype 
				         INNER JOIN `case_device_repair_complete` cc ON cc.repair=r.id
				      WHERE r.`case` = $case
				          AND YEAR(r.repairdate) = $year
				          AND MONTH(r.repairdate) = $month
				      GROUP BY t.id,ct.id,t.`name`,
				        ct.name,
				        DATE(r.repairdate) 
				      ORDER BY t.`name`,
				        DATE(r.repairdate)) st 
				    GROUP BY st.n,
				      st.cn WITH ROLLUP) f) z 
				WHERE z.cn IS NOT NULL 
				  OR (z.n IS NULL 
				    AND z.cn IS NULL)";
        
        $M = new Model();
        $list = $M->query($sql);
        $rowcount = count($list);
        $total = $list[$rowcount - 1]['rt'];
        if ($total > 0) {
            $list[$rowcount - 1]['n'] = '總數';
            $list[$rowcount - 1]['cn'] = '';
            for ($i = 0; $i < $rowcount - 1; $i ++) {
                $list[$i]['rb'] = number_format($list[$i]['rt'] * 100 / $total, 1) . '%';
            }
            $list[$rowcount]['n'] = '比例%';
            $list[$rowcount]['cn'] = '';
            for ($j = 1; $j < 32; $j ++) {
                $list[$rowcount]['day' . $j] = number_format($list[$rowcount - 1]['day' . $j] * 100 / $total, 1) . '%';
            }
        }
        for ($i = 0; $i < 31; $i ++) {
            if ($i < 10)
                $dates[$i] = $year . "-" . $month . "-0" . ($i + 1);
            else
                $dates[$i] = $year . "-" . $month . "-" . ($i + 1);
        }
        $this->assign('year', $year);
        $this->assign('month', $month);
        $this->assign("rowcount", $rowcount);
        $this->assign("dates", $dates);
        $this->assign('list', $list);
        $this->display('statisticsCompletebyMonthDetail');
    }

    function statisticsCompletebyyear()
    {
        $case = $_POST['case'];
        $year = $_POST['year'];
        if (empty($case))
            $case = $_SESSION['case'];
        if (empty($year))
            $year = date('Y');
            // 明细sql
        $sql = "SELECT
			*,
			m1 + m2 + m3 + m4 + m5 + m6 + m7 + m8 + m9 + m10 + m1 + m12 AS rt
			FROM
			(SELECT
			st.id mt,
			st.n,
			SUM(IF(st.m = 1, st.c, 0)) AS m1,
			SUM(IF(st.m = 2, st.c, 0)) AS m2,
			SUM(IF(st.m = 3, st.c, 0)) AS m3,
			SUM(IF(st.m = 4, st.c, 0)) AS m4,
			SUM(IF(st.m = 5, st.c, 0)) AS m5,
			SUM(IF(st.m = 6, st.c, 0)) AS m6,
			SUM(IF(st.m = 7, st.c, 0)) AS m7,
			SUM(IF(st.m = 8, st.c, 0)) AS m8,
			SUM(IF(st.m = 9, st.c, 0)) AS m9,
			SUM(IF(st.m = 10, st.c, 0)) AS m10,
			SUM(IF(st.m = 11, st.c, 0)) AS m11,
			SUM(IF(st.m = 12, st.c, 0)) AS m12
			FROM
			(SELECT
			t.id ,
			t.`name` AS n,
			MONTH(r.repairdate) AS m,
			COUNT(r.id) AS c
			FROM
			`case_device_repair` r
			INNER JOIN case_device_type t
			ON r.`type` = t.`id` INNER JOIN `case_device_repair_complete` cc ON cc.repair=r.id
			WHERE r.`case` = $case
			AND YEAR(r.repairdate) = $year
			GROUP BY t.id,t.`name`,
			MONTH(r.repairdate)
			ORDER BY t.`name`) st
			GROUP BY st.n WITH ROLLUP) z";
        
        $M = new Model();
        $list = $M->query($sql);
        $rowcount = count($list);
        $total = $list[$rowcount - 1]['rt'];
        if ($total > 0) {
            $list[$rowcount - 1]['n'] = '累計';
            $list[$rowcount - 1]['cn'] = '';
            for ($i = 0; $i < $rowcount - 1; $i ++) {
                $list[$i]['rb'] = number_format($list[$i]['rt'] * 100 / $total, 1) . '%';
            }
            $list[$rowcount]['n'] = '完工比例%';
            $list[$rowcount]['cn'] = '';
            for ($j = 1; $j < 13; $j ++) {
                $list[$rowcount]['m' . $j] = number_format($list[$rowcount - 1]['m' . $j] * 100 / $total, 1) . '%';
            }
        }
        $this->assign('year', $year);
        $this->assign("rowcount", $rowcount);
        $this->assign('list', $list);
        $this->display('statisticsCompletebyYear');
    }

    function statisticsCompletebyyearDetail()
    {
        $case = $_POST['case'];
        $year = $_POST['year'];
        if (empty($case))
            $case = $_SESSION['case'];
        if (empty($year))
            $year = date('Y');
            // 明细sql
        $sql = "SELECT
					*,
					m1 + m2 + m3 + m4 + m5 + m6 + m7 + m8 + m9 + m10 + m11 + m12 AS rt
					FROM
					(SELECT
					st.mt,
					st.ct,
					st.n,
					st.cn,
					SUM(IF(st.m = 1, st.c, 0)) AS m1,
					SUM(IF(st.m = 2, st.c, 0)) AS m2,
					SUM(IF(st.m = 3, st.c, 0)) AS m3,
					SUM(IF(st.m = 4, st.c, 0)) AS m4,
					SUM(IF(st.m = 5, st.c, 0)) AS m5,
					SUM(IF(st.m = 6, st.c, 0)) AS m6,
					SUM(IF(st.m = 7, st.c, 0)) AS m7,
					SUM(IF(st.m = 8, st.c, 0)) AS m8,
					SUM(IF(st.m = 9, st.c, 0)) AS m9,
					SUM(IF(st.m = 10, st.c, 0)) AS m10,
					SUM(IF(st.m = 11, st.c, 0)) AS m11,
					SUM(IF(st.m = 12, st.c, 0)) AS m12
					FROM
					(SELECT
					t.id mt,
					ct.id ct,
					t.`name` AS n,
					ct.name AS cn,
					MONTH(r.repairdate) AS m,
					COUNT(r.id) AS c
					FROM
					`case_device_repair` r
					INNER JOIN case_device_type t
					ON r.`type` = t.`id`
					INNER JOIN `case_device_child_type` ct
					ON ct.id = r.childtype INNER JOIN `case_device_repair_complete` cc ON cc.repair=r.id
					WHERE r.`case` = $case
					AND YEAR(r.repairdate) = $year
					GROUP BY t.id,ct.id, t.`name`,
					ct.name,
					MONTH(r.repairdate)
					ORDER BY t.`name`) st
					GROUP BY st.n,
					st.cn WITH ROLLUP) z
					WHERE z.cn IS NOT NULL
					OR (z.n IS NULL
					AND z.cn IS NULL)";
        
        $M = new Model();
        $list = $M->query($sql);
        $rowcount = count($list);
        $total = $list[$rowcount - 1]['rt'];
        if ($total > 0) {
            $list[$rowcount - 1]['n'] = '累計';
            $list[$rowcount - 1]['cn'] = '';
            for ($i = 0; $i < $rowcount - 1; $i ++) {
                $list[$i]['rb'] = number_format($list[$i]['rt'] * 100 / $total, 1) . '%';
            }
            $list[$rowcount]['n'] = '完工比例%';
            $list[$rowcount]['cn'] = '';
            for ($j = 1; $j < 13; $j ++) {
                $list[$rowcount]['m' . $j] = number_format($list[$rowcount - 1]['m' . $j] * 100 / $total, 1) . '%';
            }
        }
        $this->assign('year', $year);
        $this->assign("rowcount", $rowcount);
        $this->assign('list', $list);
        $this->display('statisticsCompletebyYearDetail');
    }

    function statisticsMaintenancebyMonth()
    {
        $case = $_POST['case'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        if (empty($case))
            $case = $_SESSION['case'];
        if (empty($year))
            $year = date('Y');
        if (empty($month))
            $month = date('m');
            // 明细sql
        $sql = "SELECT
		*,
		day1 + day2 + day3 + day4 + day5 + day6 + day7 + day8 + day9 + day10 + day11 + day12 + day13 + day14 + day15 + day16 + + day17 + day18 + day19 + day20 + day21 + day22 + day23 + day24 + day25 + day26 + day27 + day28 + day29 + day30 + day31 AS rt
		FROM
		(SELECT st.mt,st.n,
		SUM(IF(DAY(st.t) = 1, st.c, 0)) AS day1,
		SUM(IF(DAY(st.t) = 2, st.c, 0)) AS day2,
		SUM(IF(DAY(st.t) = 3, st.c, 0)) AS day3,
		SUM(IF(DAY(st.t) = 4, st.c, 0)) AS day4,
		SUM(IF(DAY(st.t) = 5, st.c, 0)) AS day5,
		SUM(IF(DAY(st.t) = 6, st.c, 0)) AS day6,
		SUM(IF(DAY(st.t) = 7, st.c, 0)) AS day7,
		SUM(IF(DAY(st.t) = 8, st.c, 0)) AS day8,
		SUM(IF(DAY(st.t) = 9, st.c, 0)) AS day9,
		SUM(IF(DAY(st.t) = 10, st.c, 0)) AS day10,
		SUM(IF(DAY(st.t) = 11, st.c, 0)) AS day11,
		SUM(IF(DAY(st.t) = 12, st.c, 0)) AS day12,
		SUM(IF(DAY(st.t) = 13, st.c, 0)) AS day13,
		SUM(IF(DAY(st.t) = 14, st.c, 0)) AS day14,
		SUM(IF(DAY(st.t) = 15, st.c, 0)) AS day15,
		SUM(IF(DAY(st.t) = 16, st.c, 0)) AS day16,
		SUM(IF(DAY(st.t) = 17, st.c, 0)) AS day17,
		SUM(IF(DAY(st.t) = 18, st.c, 0)) AS day18,
		SUM(IF(DAY(st.t) = 19, st.c, 0)) AS day19,
		SUM(IF(DAY(st.t) = 20, st.c, 0)) AS day20,
		SUM(IF(DAY(st.t) = 21, st.c, 0)) AS day21,
		SUM(IF(DAY(st.t) = 22, st.c, 0)) AS day22,
		SUM(IF(DAY(st.t) = 23, st.c, 0)) AS day23,
		SUM(IF(DAY(st.t) = 24, st.c, 0)) AS day24,
		SUM(IF(DAY(st.t) = 25, st.c, 0)) AS day25,
		SUM(IF(DAY(st.t) = 26, st.c, 0)) AS day26,
		SUM(IF(DAY(st.t) = 27, st.c, 0)) AS day27,
		SUM(IF(DAY(st.t) = 28, st.c, 0)) AS day28,
		SUM(IF(DAY(st.t) = 29, st.c, 0)) AS day29,
		SUM(IF(DAY(st.t) = 30, st.c, 0)) AS day30,
		SUM(IF(DAY(st.t) = 31, st.c, 0)) AS day31
		FROM (
			SELECT 
	      t.id mt,t.`name` AS n,
	      DATE(mi.`maintenancedate`) AS t,
	      COUNT(d.id) AS c 
	    FROM
	      `case_device_maintenance_detail_instance` mi 
	      INNER JOIN `case_device` d 
	        ON mi.`devicecode` = d.`devicecode` 
	      INNER JOIN case_device_type t 
	        ON t.`id` = d.`type` 
	    WHERE d.case = $case 
	      AND YEAR(mi.`maintenancedate`) = $year 
	      AND MONTH(mi.`maintenancedate`) = $month 
	    GROUP BY t.id,t.`name`,
	      DATE(mi.`maintenancedate`) 
	    ORDER BY t.`name`,
	      DATE(mi.`maintenancedate`)
		) st GROUP BY st.n  WITH ROLLUP) f";
        
        $M = new Model();
        $list = $M->query($sql);
        $rowcount = count($list);
        $total = $list[$rowcount - 1]['rt'];
        if ($total > 0) {
            $list[$rowcount - 1]['n'] = '總數';
            for ($i = 0; $i < $rowcount - 1; $i ++) {
                $list[$i]['rb'] = number_format($list[$i]['rt'] * 100 / $total, 1) . '%';
            }
            $list[$rowcount]['n'] = '比例%';
            for ($j = 1; $j < 32; $j ++) {
                $list[$rowcount]['day' . $j] = number_format($list[$rowcount - 1]['day' . $j] * 100 / $total, 1) . '%';
            }
        }
        for ($i = 0; $i < 31; $i ++) {
            if ($i < 10)
                $dates[$i] = $year . "-" . $month . "-0" . ($i + 1);
            else
                $dates[$i] = $year . "-" . $month . "-" . ($i + 1);
        }
        $this->assign('year', $year);
        $this->assign('month', $month);
        $this->assign("rowcount", $rowcount);
        $this->assign("dates", $dates);
        $this->assign('list', $list);
        $this->display('statisticsMaintenancebyMonth');
    }

    function statisticsMaintenancebyMonthDetail()
    {
        $case = $_POST['case'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        if (empty($case))
            $case = $_SESSION['case'];
        if (empty($year))
            $year = date('Y');
        if (empty($month))
            $month = date('m');
            // 明细sql
        $sql = "SELECT * FROM (
	SELECT
	*,
	day1 + day2 + day3 + day4 + day5 + day6 + day7 + day8 + day9 + day10 + day11 + day12 + day13 + day14 + day15 + day16 + + day17 + day18 + day19 + day20 + day21 + day22 + day23 + day24 + day25 + day26 + day27 + day28 + day29 + day30 + day31 AS rt
	FROM
	(SELECT st.mt,st.ct,st.n,st.cn,
	SUM(IF(DAY(st.t) = 1, st.c, 0)) AS day1,
	SUM(IF(DAY(st.t) = 2, st.c, 0)) AS day2,
	SUM(IF(DAY(st.t) = 3, st.c, 0)) AS day3,
	SUM(IF(DAY(st.t) = 4, st.c, 0)) AS day4,
	SUM(IF(DAY(st.t) = 5, st.c, 0)) AS day5,
	SUM(IF(DAY(st.t) = 6, st.c, 0)) AS day6,
	SUM(IF(DAY(st.t) = 7, st.c, 0)) AS day7,
	SUM(IF(DAY(st.t) = 8, st.c, 0)) AS day8,
	SUM(IF(DAY(st.t) = 9, st.c, 0)) AS day9,
	SUM(IF(DAY(st.t) = 10, st.c, 0)) AS day10,
	SUM(IF(DAY(st.t) = 11, st.c, 0)) AS day11,
	SUM(IF(DAY(st.t) = 12, st.c, 0)) AS day12,
	SUM(IF(DAY(st.t) = 13, st.c, 0)) AS day13,
	SUM(IF(DAY(st.t) = 14, st.c, 0)) AS day14,
	SUM(IF(DAY(st.t) = 15, st.c, 0)) AS day15,
	SUM(IF(DAY(st.t) = 16, st.c, 0)) AS day16,
	SUM(IF(DAY(st.t) = 17, st.c, 0)) AS day17,
	SUM(IF(DAY(st.t) = 18, st.c, 0)) AS day18,
	SUM(IF(DAY(st.t) = 19, st.c, 0)) AS day19,
	SUM(IF(DAY(st.t) = 20, st.c, 0)) AS day20,
	SUM(IF(DAY(st.t) = 21, st.c, 0)) AS day21,
	SUM(IF(DAY(st.t) = 22, st.c, 0)) AS day22,
	SUM(IF(DAY(st.t) = 23, st.c, 0)) AS day23,
	SUM(IF(DAY(st.t) = 24, st.c, 0)) AS day24,
	SUM(IF(DAY(st.t) = 25, st.c, 0)) AS day25,
	SUM(IF(DAY(st.t) = 26, st.c, 0)) AS day26,
	SUM(IF(DAY(st.t) = 27, st.c, 0)) AS day27,
	SUM(IF(DAY(st.t) = 28, st.c, 0)) AS day28,
	SUM(IF(DAY(st.t) = 29, st.c, 0)) AS day29,
	SUM(IF(DAY(st.t) = 30, st.c, 0)) AS day30,
	SUM(IF(DAY(st.t) = 31, st.c, 0)) AS day31
	FROM (
	SELECT 
      t.id mt, ct.id ct,t.`name` AS n,
      ct.name AS cn,
      DATE(mi.`maintenancedate`) AS t,
      COUNT(d.id) AS c 
    FROM
      `case_device_maintenance_detail_instance` mi 
      INNER JOIN `case_device` d 
        ON mi.`devicecode` = d.`devicecode` 
      INNER JOIN case_device_type t 
        ON t.`id` = d.`type` 
      INNER JOIN `case_device_child_type` ct ON d.childtype = ct.id
    WHERE d.case = $case 
      AND YEAR(mi.`maintenancedate`) = $year 
      AND MONTH(mi.`maintenancedate`) = $month 
    GROUP BY t.id,ct.id,t.`name`, ct.name,
      DATE(mi.`maintenancedate`) 
    ORDER BY t.`name`, ct.name,
      DATE(mi.`maintenancedate`)
	) st GROUP BY st.n,st.cn  WITH ROLLUP) f) z WHERE z.cn IS NOT NULL OR (z.n IS NULL AND z.cn IS NULL)";
        
        $M = new Model();
        $list = $M->query($sql);
        $rowcount = count($list);
        $total = $list[$rowcount - 1]['rt'];
        if ($total > 0) {
            $list[$rowcount - 1]['n'] = '總數';
            $list[$rowcount - 1]['cn'] = '';
            for ($i = 0; $i < $rowcount - 1; $i ++) {
                $list[$i]['rb'] = number_format($list[$i]['rt'] * 100 / $total, 1) . '%';
            }
            $list[$rowcount]['n'] = '比例%';
            $list[$rowcount]['cn'] = '';
            for ($j = 1; $j < 32; $j ++) {
                $list[$rowcount]['day' . $j] = number_format($list[$rowcount - 1]['day' . $j] * 100 / $total, 1) . '%';
            }
        }
        for ($i = 0; $i < 31; $i ++) {
            if ($i < 10)
                $dates[$i] = $year . "-" . $month . "-0" . ($i + 1);
            else
                $dates[$i] = $year . "-" . $month . "-" . ($i + 1);
        }
        $this->assign('year', $year);
        $this->assign('month', $month);
        $this->assign("rowcount", $rowcount);
        $this->assign("dates", $dates);
        $this->assign('list', $list);
        $this->display('statisticsMaintenancebyMonthDetail');
    }

    function statisticsMaintenancebyYear()
    {
        $case = $_POST['case'];
        $year = $_POST['year'];
        if (empty($case))
            $case = $_SESSION['case'];
        if (empty($year))
            $year = date('Y');
            // 明细sql
        $sql = "SELECT 
		  *,
		  m1 + m2 + m3 + m4 + m5 + m6 + m7 + m8 + m9 + m10 + m11 + m12 AS rt 
		FROM
		  (SELECT 
		  	st.mt,
		    st.n,
		    SUM(IF(st.m = 1, st.c, 0)) AS m1,
		    SUM(IF(st.m = 2, st.c, 0)) AS m2,
		    SUM(IF(st.m = 3, st.c, 0)) AS m3,
		    SUM(IF(st.m = 4, st.c, 0)) AS m4,
		    SUM(IF(st.m = 5, st.c, 0)) AS m5,
		    SUM(IF(st.m = 6, st.c, 0)) AS m6,
		    SUM(IF(st.m = 7, st.c, 0)) AS m7,
		    SUM(IF(st.m = 8, st.c, 0)) AS m8,
		    SUM(IF(st.m = 9, st.c, 0)) AS m9,
		    SUM(IF(st.m = 10, st.c, 0)) AS m10,
		    SUM(IF(st.m = 11, st.c, 0)) AS m11,
		    SUM(IF(st.m = 12, st.c, 0)) AS m12 
		  FROM
		    (SELECT 
		      t.id mt,
		      t.`name` AS n,
		      MONTH(mi.`maintenancedate`) AS m,
		      COUNT(d.id) AS c 
		    FROM
		      `case_device_maintenance_detail_instance` mi 
		      INNER JOIN `case_device` d 
		        ON mi.`devicecode` = d.`devicecode` 
		      INNER JOIN case_device_type t 
		        ON t.`id` = d.`type` 
		     
		    WHERE d.case = $case 
		      AND YEAR(mi.`maintenancedate`) = $year 
		    GROUP BY t.id,t.`name`,
		      DATE(mi.`maintenancedate`) 
		    ORDER BY t.`name`,
		      DATE(mi.`maintenancedate`)) st 
		  GROUP BY st.n WITH ROLLUP) z ";
        
        $M = new Model();
        $list = $M->query($sql);
        $rowcount = count($list);
        $total = $list[$rowcount - 1]['rt'];
        if ($total > 0) {
            $list[$rowcount - 1]['n'] = '累計';
            $list[$rowcount - 1]['cn'] = '';
            for ($i = 0; $i < $rowcount - 1; $i ++) {
                $list[$i]['rb'] = number_format($list[$i]['rt'] * 100 / $total, 1) . '%';
            }
            $list[$rowcount]['n'] = '保養比例%';
            $list[$rowcount]['cn'] = '';
            for ($j = 1; $j < 13; $j ++) {
                $list[$rowcount]['m' . $j] = number_format($list[$rowcount - 1]['m' . $j] * 100 / $total, 1) . '%';
            }
        }
        $this->assign('year', $year);
        $this->assign("rowcount", $rowcount);
        $this->assign('list', $list);
        $this->display('statisticsMaintenancebyYear');
    }

    function statisticsMaintenancebyYearDetail()
    {
        $case = $_POST['case'];
        $year = $_POST['year'];
        if (empty($case))
            $case = $_SESSION['case'];
        if (empty($year))
            $year = date('Y');
            // 明细sql
        $sql = "SELECT * FROM (SELECT 
				  *,
				  m1 + m2 + m3 + m4 + m5 + m6 + m7 + m8 + m9 + m10 + m11 + m12 AS rt 
				FROM
				  (SELECT 
				  	st.mt,st.ct,
				    st.n,st.cn,
				    SUM(IF(st.m = 1, st.c, 0)) AS m1,
				    SUM(IF(st.m = 2, st.c, 0)) AS m2,
				    SUM(IF(st.m = 3, st.c, 0)) AS m3,
				    SUM(IF(st.m = 4, st.c, 0)) AS m4,
				    SUM(IF(st.m = 5, st.c, 0)) AS m5,
				    SUM(IF(st.m = 6, st.c, 0)) AS m6,
				    SUM(IF(st.m = 7, st.c, 0)) AS m7,
				    SUM(IF(st.m = 8, st.c, 0)) AS m8,
				    SUM(IF(st.m = 9, st.c, 0)) AS m9,
				    SUM(IF(st.m = 10, st.c, 0)) AS m10,
				    SUM(IF(st.m = 11, st.c, 0)) AS m11,
				    SUM(IF(st.m = 12, st.c, 0)) AS m12 
				  FROM
				    (SELECT 
				     t.id mt,ct.id ct, t.`name` AS n,
				      ct.name AS cn,
				      MONTH(mi.`maintenancedate`) AS m,
				      COUNT(d.id) AS c 
				    FROM
				      `case_device_maintenance_detail_instance` mi 
				      INNER JOIN `case_device` d 
				        ON mi.`devicecode` = d.`devicecode` 
				      INNER JOIN case_device_type t 
				        ON t.`id` = d.`type` 
				      INNER JOIN `case_device_child_type` ct ON d.childtype = ct.id
				    WHERE d.case = $case 
				      AND YEAR(mi.`maintenancedate`) = $year 
				    GROUP BY t.`name`, ct.name,
				      DATE(mi.`maintenancedate`) 
				    ORDER BY t.id ,ct.id,t.`name`, ct.name,
				      DATE(mi.`maintenancedate`)) st 
				  GROUP BY st.n,st.cn WITH ROLLUP) f )  z WHERE  z.cn IS NOT NULL
					OR (z.n IS NULL
					AND z.cn IS NULL)";
        
        $M = new Model();
        $list = $M->query($sql);
        $rowcount = count($list);
        $total = $list[$rowcount - 1]['rt'];
        if ($total > 0) {
            $list[$rowcount - 1]['n'] = '累計';
            $list[$rowcount - 1]['cn'] = '';
            for ($i = 0; $i < $rowcount - 1; $i ++) {
                $list[$i]['rb'] = number_format($list[$i]['rt'] * 100 / $total, 1) . '%';
            }
            $list[$rowcount]['n'] = '保養比例%';
            $list[$rowcount]['cn'] = '';
            for ($j = 1; $j < 13; $j ++) {
                $list[$rowcount]['m' . $j] = number_format($list[$rowcount - 1]['m' . $j] * 100 / $total, 1) . '%';
            }
        }
        $this->assign('year', $year);
        $this->assign("rowcount", $rowcount);
        $this->assign('list', $list);
        $this->display('statisticsMaintenancebyYearDetail');
    }

    function statisticsmaintenancedetail()
    {
        $case = $_GET['case'];
        $maintype = $_GET['maintype'];
        $childtype = $_GET['childtype'];
        $year = $_GET['year'];
        $month = $_GET['month'];
        $this->assign("action", __SELF__);
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $sql = "SELECT * FROM (SELECT
			i.*,mt.`id` mt,ct.`id` ct,
			IF(ISNULL(i.state),
			IF(
			ISNULL(z.cstate),
			'正常',
			'異常'
			),i.`state`) cstate
			FROM
			case_device_maintenance_detail_instance i
			INNER JOIN `case_device` d ON i.`devicecode`=d.`devicecode`
			INNER JOIN `case_device_type` mt ON d.`type`=mt.`id`
			INNER JOIN `case_device_child_type` ct ON d.`childtype`=ct.`id`
			LEFT  JOIN
			(SELECT
			COUNT(b.id) AS cstate,
			b.`instance`
			FROM
			`case_device_maintenance_detail_instance_detail` b
				
			WHERE result = '異常'
			OR result < `floor`
			OR result > cap
			GROUP BY b.`instance`) z
			ON i.`id` = z.instance
			WHERE i.`case`=$case) X
			
			WHERE mt=$maintype AND YEAR(maintenancedate)=$year";
            if (! empty($month)) {
                $sql .= " AND MONTH(maintenancedate)=$month";
            }
            if (! empty($childtype)) {
                $sql .= " AND ct=$childtype";
            }
            $dao = new Model();
            $list = $dao->query($sql);
            $this->assign("list", $list);
            $this->display("statisticsmaintenancedetail");
        } else {
            $sql = "SELECT   
			`maintenancecode`,
			  `maintenancedate`,
			  `devicecode`,
			  `devicename`,
			  `maintenanceuser`,
			  cstate  FROM (SELECT
			i.*,mt.`id` mt,ct.`id` ct,
			IF(ISNULL(i.state),
			IF(
			ISNULL(z.cstate),
			'正常',
			'異常'
			),i.`state`) cstate
			FROM
			case_device_maintenance_detail_instance i
			INNER JOIN `case_device` d ON i.`devicecode`=d.`devicecode`
			INNER JOIN `case_device_type` mt ON d.`type`=mt.`id`
			INNER JOIN `case_device_child_type` ct ON d.`childtype`=ct.`id`
			LEFT  JOIN
			(SELECT
			COUNT(b.id) AS cstate,
			b.`instance`
			FROM
			`case_device_maintenance_detail_instance_detail` b
				
			WHERE result = '異常'
			OR result < `floor`
			OR result > cap
			GROUP BY b.`instance`) z
			ON i.`id` = z.instance
			WHERE i.`case`=$case) X
			
			WHERE mt=$maintype AND YEAR(maintenancedate)=$year";
            if (! empty($month)) {
                $sql .= " AND MONTH(maintenancedate)=$month";
            }
            if (! empty($childtype)) {
                $sql .= " AND ct=$childtype";
            }
            $dao = new Model();
            $list = $dao->query($sql);
            $downName = '保養列表';
            $headers = '保養編號,保養日期,設備編號,設備名稱,保養人,狀態';
            $this->cvsDown($list, $headers, $downName);
        }
    }

    function statisticsbyfault()
    {
        $case = $_POST['case'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        if (empty($case))
            $case = $_SESSION['case'];
        if (empty($year))
            $year = date('Y');
        if (empty($month))
            $month = date('m');
            // 明细sql
        $sql = "SELECT z.dd,
			SUM(IF(ISNULL(z.al),0,z.al)) AS  al,
			SUM(IF(ISNULL(z.currday),0,z.currday)) AS currday,
			SUM(IF(ISNULL(z.afteraday),0,z.afteraday)) AS afteraday,
			SUM(IF(ISNULL(z.morethan2day),0,z.morethan2day)) AS morethan2day,
			SUM(IF(ISNULL(z.nonecomplete),0,z.nonecomplete)) AS nonecomplete
			 FROM (
			SELECT * FROM   
			(SELECT CONCAT('$year','-','$month','-',d.`day`) dd FROM `case_device_maintenance_days` d) days
			 LEFT OUTER JOIN   
			  (SELECT 
			    DATE(cr.`repairdate`) rd ,
			    COUNT(cr.`id`) AS al,
			    SUM(IF(DATEDIFF(cr.`repairdate`,cc.completedate)=0 OR cc.`completedate`='0000-00-00 00:00:00',1,0)) AS currday,
			    SUM(IF(DATEDIFF(cr.`repairdate`,cc.completedate)=1,1,0)) AS afteraday,
			    SUM(IF(DATEDIFF(cr.`repairdate`,cc.completedate)>=2,1,0)) AS morethan2day,
			    SUM(IF(ISNULL(cc.completedate),1,0)) AS nonecomplete
			
			  FROM
			    `case_device_repair` cr 
				LEFT OUTER JOIN `case_device_repair_complete` cc 
			      ON cr.`id` = cc.repair WHERE cr.`case`=$case AND Year(cr.`repairdate`)='$year' AND MONTH(cr.`repairdate`)='$month'
			   GROUP BY DATE(cr.`repairdate`)
			  ) datas 
			   ON days.dd =datas.rd) z  GROUP BY z.dd WITH ROLLUP  ";
        
        $M = new Model();
        $list = $M->query($sql);
        $rowcount = count($list);
        $total = $list[$rowcount - 1]['al'];
        if ($total > 0) {
            $list[$rowcount - 1]['dd'] = '統計';
            $list[$rowcount]['dd'] = '比率';
            $list[$rowcount]['al'] = '100%';
            $list[$rowcount]['currday'] = number_format($list[$rowcount - 1]['currday'] * 100 / $total, 1) . '%';
            $list[$rowcount]['afteraday'] = number_format($list[$rowcount - 1]['afteraday'] * 100 / $total, 1) . '%';
            $list[$rowcount]['morethan2day'] = number_format($list[$rowcount - 1]['morethan2day'] * 100 / $total, 1) . '%';
            $list[$rowcount]['nonecomplete'] = number_format($list[$rowcount - 1]['nonecomplete'] * 100 / $total, 1) . '%';
        }
        $this->assign('year', $year);
        $this->assign('month', $month);
        $this->assign('list', $list);
        $this->display('statisticsbyfault');
    }

    function warnSetting()
    {
        $warn = M('case_warn_days');
        $data = $warn->where('`case` = ' . $_SESSION['case'])->find();
        $this->assign('warn', $data);
        $this->display('warnSetting');
    }

    function saveSetting()
    {
        $warn = M('case_warn_days');
        $data = $warn->create();
        if (! empty($data['id'])) {
            $warn->save($data);
        } else {
            $warn->add($data);
        }
        $this->warnSetting();
    }

    function exportDevice()
    {
        $title = '設備.xls';
        $headers = '棟別ID,棟別,樓層ID,樓層,區域ID,區域,設備編號 ,設備名稱,主類別ID,主類別,子類別ID,子類別';
        $sql = "SELECT                  b.`id` bid,
			b.`name` bname,
			f.`id` fid,
			f.`name` fname,
			a.`id` aid,
			a.`name` aname,
			
			d.`devicecode`,
			d.`name`,
			t.`id` tid,
			t.`name` AS tname,
			ct.`id` ctid,
			ct.`name` AS ctname 
			FROM
			  case_device d 
			  INNER JOIN case_device_building_floor_area a 
			    ON d.`area` = a.id 
			  INNER JOIN case_device_building_floor f 
			    ON d.floor = f.id 
			  INNER JOIN `case_device_buildingtype` b
			  ON d.`build`=b.`id`
			  INNER JOIN case_device_type t 
			    ON d.`type` = t.`id` 
			  INNER JOIN case_device_child_type ct 
			    ON d.`childtype` = ct.`id` 
			WHERE d.`case` =" . $_SESSION['case'];
        $q = new Model();
        $data = $q->query($sql);
        $this->export($title, $headers, $data);
    }
    
    /*
     * 業主管理******************************************************************************************************************************
     */
    /* 承租戶管理****************************************************************************************************************************** */
    function proprietorList()
    {
        import("ORG.Util.Page");
        $name = $this->getParam('sname');
        $areacode = $this->getParam('sareacode');
        $areaname = $this->getParam('sareaname');
        $state = $this->getParam('sstate');
        $sprice = $this->getParam('sprice');
        $eprice = $this->getParam('eprice');
        $scharge = $this->getParam('scharge');
        $echarge = $this->getParam('echarge');
        $proprietor = M('case_proprietor');
        $sql = "SELECT 
		  p.* ,r.`code`,r.name  rname 
		FROM
		  `case_proprietor` p 
		  INNER JOIN `case_rentunit` r 
		    ON p.`unit` = r.`id` WHERE p.`case` =" . $_SESSION['case'];
        
        if (! empty($name)) {
            $where .= " and p.name like '%$name%'";
        }
        if (! empty($areacode)) {
            $where .= " and r.code = '$areacode'";
        }
        if (! empty($areaname)) {
            $where .= " and r.name like '%$areaname%'";
        }
        if (! empty($state)) {
            $where .= " and p.state = '$state'";
        }
        if (! empty($sprice)) {
            $where .= " and p.priceperm3 >= '$sprice'";
        }
        if (! empty($eprice)) {
            $where .= " and p.priceperm3 <= '$eprice'";
        }
        if (! empty($scharge)) {
            $where .= " and p.charge >= '$scharge'";
        }
        if (! empty($echarge)) {
            $where .= " and p.charge <= '$echarge'";
        }
        $list = $proprietor->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $p->parameter .= "&" . parent::getParameter();
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $proprietor->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('proprietorList');
    }

    function proprietorAddPage()
    {
        // 查詢
        $rent = M('case_rentunit');
        $units = $rent->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("units", $units);
        $this->display('proprietorAdd');
    }

    function proprietorAdd()
    {
        $file = M('case_proprietor');
        $data = $file->create();
        import("ORG.Net.UploadFile");
        $up = new UploadFile();
        $up->savePath = ATTCHEMENT_PATH_CASEFILE;
        $up->saveRule = 'uniqid';
        $up->uploadReplace = true;
        if ($up->upload()) {
            $files = $up->getUploadFileInfo();
            $paths = $files[0]["savename"];
            $data['atts'] = $paths;
        }
        if (empty($data['id']))
            $file->add($data);
        else
            $file->save($data);
        $this->proprietorList();
    }

    function proprietorEdit()
    {
        // 查詢
        $rent = M('case_rentunit');
        $units = $rent->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("units", $units);
        
        $proprietor = M('case_proprietor');
        $data = $proprietor->find($_GET['id']);
        $this->assign('prop', $data);
        $this->display('proprietorEdit');
    }

    function proprietorView()
    {
        $proprietor = new Model();
        $sql = "SELECT 
		  p.* ,r.`code`,r.name  rname 
		FROM
		  `case_proprietor` p 
		  INNER JOIN `case_rentunit` r 
		    ON p.`unit` = r.`id` WHERE p.id=" . $_GET['id'];
        $data = $proprietor->query($sql);
        $this->assign('prop', $data[0]);
        $this->display('proprietorView');
    }

    function proprietorDelete()
    {
        $proprietor = M('case_proprietor');
        $proprietor->delete($_GET['id']);
        $this->proprietorList();
    }
    /*
     * 承租單位管理******************************************************************************************************************************
     */
    function rentunitList()
    {
        $rent = M('case_rentunit');
        $name = $this->getParam('sname');
        $state = $this->getParam('sstate');
        $sbfa = $this->getParam('sbfa');
        import("ORG.Util.Page");
        $sql = "SELECT 
			  r.*,p.`charge`,b.`name` bname ,f.`name` fname, a.`name` aname
			FROM
			  case_rentunit r 
			  LEFT JOIN case_proprietor p 
			    ON r.id = p.`unit` 
			  INNER JOIN `case_device_buildingtype` b 
			    ON b.`id` = r.`build` 
			  INNER JOIN `case_device_building_floor` f 
			    ON f.`id` = r.`floor` 
			  INNER JOIN `case_device_building_floor_area` a 
			    ON a.`id` = r.`area` 
					WHERE r.`case`=" . $_SESSION['case'];
        if (! empty($name)) {
            $sql .= " and r.name like '%$name%'";
        }
        if (! empty($state)) {
            $sql .= " and r.state = '$state'";
        }
        if (! empty($sbfa)) {
            $sql .= " CONCAT(b.`name`,f.`name`,a.`name`)  like '%$sbfa%'";
        }
        import("ORG.Util.Page");
        $list = $rent->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $p->parameter .= "&" . parent::getParameter();
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $rent->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('rentunitList');
    }

    function rentunitAddPage()
    {
        // 查詢東別
        $b = M('case_device_buildingtype');
        $builds = $b->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("builds", $builds);
        $this->display('rentunitAdd');
    }

    function rentunitAdd()
    {
        $rent = M('case_rentunit');
        $data = $rent->create();
        $id = $data['id'];
        if (empty($id)) {
            $rent->add($data);
        } else {
            $rent->save($data);
        }
        $this->rentunitList();
    }

    function rentunitEdit()
    {
        // 查詢東別
        $b = M('case_device_buildingtype');
        $builds = $b->where(" `case` = " . $_SESSION['case'])->select();
        $this->assign("builds", $builds);
        
        $rent = M('case_rentunit');
        $sql = "SELECT
		r.*,p.`charge`,b.`name` bname ,f.`name` fname, a.`name` aname,p.`charge`/r.`space` pprice
		FROM
		case_rentunit r
		LEFT JOIN case_proprietor p
		ON r.id = p.`unit`
		INNER JOIN `case_device_buildingtype` b
		ON b.`id` = r.`build`
		INNER JOIN `case_device_building_floor` f
		ON f.`id` = r.`floor`
		INNER JOIN `case_device_building_floor_area` a
		ON a.`id` = r.`area`
		WHERE r.`id`=" . $_GET['id'];
        $data = $rent->query($sql);
        $this->assign('rent', $data[0]);
        $this->display('rentunitEdit');
    }

    function rentunitDelete()
    {
        $rent = M('case_rentunit');
        $rent->delete($_GET['id']);
        $this->rentunitList();
    }
    /*
     * 繳費紀錄******************************************************************************************************************************
     */
    function payList()
    {
        $clientname = $this->getParam('sclientname');
        $month = $this->getParam('smonth');
        $sql = "SELECT 
		  p.* ,c.`name`,u.`code`,u.`name` uname
		FROM
		  `case_pay` p 
		  INNER JOIN `case_proprietor` c 
		    ON p.`clientid` = c.`id` 
		   INNER JOIN `case_rentunit` u
		   ON c.`unit`=u.`id`
  		 WHERE p.`case` =" . $_SESSION['case'];
        if (! empty($clientname)) {
            $sql .= " and c.name  like '%$clientname%'";
        }
        if (! empty($month)) {
            $sql .= " and MONTH(p.`paydate`)=$month";
        }
        import("ORG.Util.Page");
        $pay = new Model();
        $list = $pay->query($sql);
        $count = count($list);
        $p = $this->getPage($count);
        $p->parameter .= "&" . parent::getParameter();
        $page = $p->show();
        if ($count > 0) {
            $sql = $sql . " limit " . $p->firstRow . ',' . $p->listRows;
            $list = $pay->query($sql);
        }
        $this->assign("list", $list);
        $this->assign("page", $page);
        $this->display('payList');
    }

    function payAddPage()
    {
        $this->queryProprietor();
        
        $this->display('payAdd');
    }

    /**
     */
    private function queryProprietor()
    {
        // 查询客户
        $C = M('case_proprietor');
        $sql = "SELECT 
		  p.*,CONCAT(b.`name`,f.`name`,a.`name`) AS area 
		FROM
		  `case_proprietor` p 
		  INNER JOIN `case_rentunit` r 
		    ON p.`unit` = r.`id` 
		   INNER JOIN `case_device_building_floor_area` a
		   ON a.`id`=r.`area`
		   INNER JOIN `case_device_building_floor` f
		   ON r.`floor`=f.`id`
		   INNER JOIN `case_device_buildingtype` b ON
		   b.`id`=r.`build`
		WHERE r.`case` =" . $_SESSION['case'];
        $cps = $C->query($sql);
        $this->assign('cps', $cps);
    }

    function payAdd()
    {
        $pay = M('case_pay');
        $data = $pay->create();
        $id = $data['id'];
        if (empty($id)) {
            $pay->add($data);
        } else {
            $pay->save($data);
        }
        $this->payList();
    }

    function payEdit()
    {
        $this->queryProprietor();
        $pay = M('case_pay');
        $data = $pay->find($_GET['id']);
        $this->assign('pay', $data);
        $this->display('payEdit');
    }

    function payDelete()
    {
        $pay = M('case_pay');
        $pay->delete($_GET['id']);
        $this->payList();
    }
    /*
     * 抄表管理******************************************************************************************************************************
     */
    function copyFormList()
    {
        import("ORG.Util.Page");
        $copy = M('case_copyform');
        $where = '`case` = ' . $_SESSION['case'];
        $type = $this->getParam("stype");
        $user = $this->getParam("suser");
        if (! empty($user))
            $where .= " AND username like '%$user%'";
        if (! empty($type))
            $where .= " AND type like '%$type%'";
        $count = $copy->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $copy->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display('copyFormList');
    }

    function copyFormAddPage()
    {
        $this->display('copyFormAdd');
    }

    function copyFormAdd()
    {
        $copy = M('case_copyform');
        $data = $copy->create();
        $id = $data['id'];
        if (empty($id)) {
            $copy->add($data);
        } else {
            $copy->save($data);
        }
        $this->copyFormList();
    }

    function copyFormEdit()
    {
        $id = $_GET['id'];
        $copy = M('case_copyform');
        $data = $copy->find($id);
        $this->assign('copy', $data);
        $this->display('copyFormEdit');
    }

    function copyFormView()
    {
        $id = $_GET['id'];
        $copy = M('case_copyform');
        $data = $copy->find($id);
        $this->assign('copy', $data);
        $this->display('copyFormView');
    }

    function copyFormDelete()
    {
        $id = $_GET['id'];
        $copy = M('case_copyform');
        $copy->delete($id);
        $this->copyFormList();
    }
    /*
     * 抄表紀錄列表******************************************************************************************************************************
     */
    function copyFormHistoryList()
    {
        import("ORG.Util.Page");
        $date = $this->getParam("sdate");
        $copy = M('case_copyform_history');
        $where = '`case` = ' . $_SESSION['case'];
        if (! empty($date))
            $where .= " AND datediff(copydate,'$date' )=0";
        $count = $copy->where($where)->count();
        $p = $this->getPage($count);
        $page = $p->show();
        $list = $copy->where($where)
            ->order('id desc')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->select();
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display('copyFormHistoryList');
    }

    function copyFormHistoryAddPage()
    {
        $case = $_SESSION['case'];
        $sql = "SELECT 
		  ccf.*,
		  IF(
		    ISNULL(cch.alldegree),
		    0,
		    cch.alldegree
		  ) predegree 
		FROM
		  `case_copyform` ccf 
		  LEFT JOIN 
		    (SELECT 
		      c.* 
		    FROM
		      `case_copyform_history` m 
		      INNER JOIN `case_copyform_history_detail` c 
		        ON m.id = c.`copyid` 
		    WHERE m.id = 
		      (SELECT 
		        MAX(id) 
		      FROM
		        `case_copyform_history` 
		      WHERE `case` = $case)) cch 
		    ON ccf.`gaugecode` = cch.`gaugecode`  WHERE ccf.`case` = $case";
        $query = new Model();
        $data = $query->query($sql);
        $this->assign('list', $data);
        $this->display('copyFormHistoryAdd');
    }

    function copyFormHistoryAdd()
    {
        $copy = M('case_copyform_history');
        try {
            $copy->startTrans();
            $data = $copy->create();
            $data['copydate'] = date('Y-m-d');
            $data['copydatetime'] = date('Y-m-d h:i:s');
            
            $id = $data['id'];
            if (empty($id)) {
                $id = $copy->add($data);
                $this->copyDetail($id, false);
            } else {
                $copy->save($data);
                $this->copyDetail($id, true);
            }
            $copy->commit();
        } catch (Exception $e) {
            $copy->rollback();
        }
        $this->copyFormHistoryList();
    }

    function copyDetail($id, $isUpdate)
    {
        $datas = $_POST['data'];
        $cd = M('case_copyform_history_detail');
        if ($isUpdate)
            $cd->where('copyid =' . $id)->delete();
        if (! empty($datas)) {
            $details = json_decode($datas, true);
            $data['copyid'] = $id;
            foreach ($details as $key => $value) {
                $data['code'] = $value['code'];
                $data['area'] = $value['area'];
                $data['username'] = $value['username'];
                $data['gaugecode'] = $value['gaugecode'];
                $data['type'] = $value['type'];
                $data['predegree'] = $value['predegree'];
                $data['alldegree'] = $value['alldegree'];
                $data['thisdegree'] = $value['thisdegree'];
                $cd->add($data);
            }
        }
    }

    function copyFormHistoryEdit()
    {
        $id = $_GET['id'];
        $copy = M('case_copyform_history');
        $data = $copy->find($id);
        $this->assign('copy', $data);
        $copydetail = M('case_copyform_history_detail');
        $datadetail = $copydetail->where('copyid =' . $id)->select();
        $this->assign('copydetail', $datadetail);
        $this->display('copyFormHistoryEdit');
    }

    function copyFormHistoryDelete()
    {
        $id = $_GET['id'];
        $copy = M('case_copyform_history');
        $copy->delete($id);
        $cd = M('case_copyform_history_detail');
        $cd->where('copyid =' . $id)->delete();
        $this->copyFormHistoryList();
    }

    function copyFormHistoryView()
    {
        $id = $_GET['id'];
        $this->assign('id', $id);
        $copydetail = M('case_copyform_history_detail');
        $datadetail = $copydetail->where('copyid =' . $id)->select();
        $this->assign('copydetail', $datadetail);
        $this->display('copyFormHistoryView');
    }

    function ImportDevices()
    {
        
        // 縣上傳EXCEL
        import("ORG.Net.UploadFile");
        $up = new UploadFile();
        $up->savePath = ATTCHEMENT_PATH_CASEFILE;
        $up->saveRule = 'uniqid';
        $up->uploadReplace = true;
        if ($up->upload()) {
            
            $files = $up->getUploadFileInfo();
            $path = $files[0]["savename"];
            
            $filename = BASEPATH . "/Public/Uploads/atts/case/" . $path;
            
            chmod($filename, 0777);
            
            vendor('PHPExcelReader.Reader');
            
            $data = new Spreadsheet_Excel_Reader();
            $data->read($filename);
            $device = M('case_device_imp_temp');
            try {
                $device->startTrans();
                $sql = "delete from case_device_imp_temp where uid=" . $this->id;
                $ret = $device->execute($sql);
                $this->checkExcept($ret);
                for ($i = 1; $i <= $data->sheets[0]['numRows']; $i ++) {
                    // $rowdata ['db'] = $data->sheets [0] ['cells'] [$i] [1];
                    // $rowdata ['lc'] = $data->sheets [0] ['cells'] [$i] [2];
                    // $rowdata ['qy'] = $data->sheets [0] ['cells'] [$i] [3];
                    // $rowdata ['sbbh'] = $data->sheets [0] ['cells'] [$i] [4];
                    // $rowdata ['zlb'] = $data->sheets [0] ['cells'] [$i] [5];
                    // $rowdata ['zilb'] = $data->sheets [0] ['cells'] [$i] [6];
                    // $rowdata ['sbmc'] = $data->sheets [0] ['cells'] [$i] [7];
                    // $rowdata ['case'] = $_SESSION ['case'];
                    // $rowdata ['uid'] = $this->id;
                    // $sqldata [] = $rowdata;
                    $db = $data->sheets[0]['cells'][$i][1];
                    $lc = $data->sheets[0]['cells'][$i][2];
                    $qy = $data->sheets[0]['cells'][$i][3];
                    $sbbh = $data->sheets[0]['cells'][$i][4];
                    $zlb = $data->sheets[0]['cells'][$i][5];
                    $zilb = $data->sheets[0]['cells'][$i][6];
                    $sbmc = $data->sheets[0]['cells'][$i][7];
                    $case = $_SESSION['case'];
                    $uid = $this->id;
                    
                    $sql = "INSERT INTO `case_device_imp_temp` (`db`, `lc`, `qy`,
					 		 `sbbh`, `zlb`, `zilb`, `sbmc`, `case`, `uid`) VALUES ('$db',
					 				 '$lc', '$qy', '$sbbh', '$zlb', '$zilb', '$sbmc', '$case',
					 				 '$uid');";
                    
                    $ret = $device->execute($sql);
                    $this->checkExcept($ret);
                }
                $sql = "INSERT INTO `case_device` (
						  `case`,
						  `name`,
						  `devicecode`,
						  `build`,
						  `floor`,
						  `area`,
						  `type`,
						  `childtype`
						) 
						
					SELECT 
					  * 
					FROM
					  (SELECT 
					    '$case',
					    sbmc,
					    sbbh,
					 
					    (SELECT 
					      id 
					    FROM
					      `case_device_buildingtype` 
					    WHERE `name` = db 
					      AND `case` = $case) AS db,
					      
					    (SELECT 
					      id 
					    FROM
					      `case_device_building_floor` 
					    WHERE `name` = lc 
					      AND `buildingtype` = (SELECT 
					      id 
					    FROM
					      `case_device_buildingtype` 
					    WHERE `name` = db 
					      AND `case` = $case)) AS lc,
					      
					      
					    (SELECT 
					      id 
					    FROM
					      `case_device_building_floor_area` 
					    WHERE `name` = qy 
					      AND `floor` = 
					      (SELECT 
					        id 
					      FROM
					        case_device_building_floor 
					      WHERE `buildingtype` = (SELECT 
					      id 
					    FROM
					      `case_device_buildingtype` 
					    WHERE `name` = db 
					      AND `case` = $case)AND `name` =lc)
					    LIMIT 1) AS qy,
					    (SELECT 
					      id 
					    FROM
					      `case_device_type` 
					    WHERE `name` = zlb 
					      AND `case` = $case) AS zlb,
					    (SELECT 
					      id 
					    FROM
					      `case_device_child_type` 
					    WHERE `name` = zilb 
					      AND TYPE IN 
					      (SELECT 
					        id 
					      FROM
					        `case_device_type` 
					      WHERE `case` = $case)) AS zilb 
					  FROM
					    case_device_imp_temp) X
					WHERE db IS NOT NULL 
					  AND lc IS NOT NULL 
					  AND qy IS NOT NULL 
					  AND zlb IS NOT NULL 
					  AND zilb IS NOT NULL ";
                $ret = $device->execute($sql);
                echo $sql;
                $this->checkExcept($ret);
                $device->commit();
                $this->ShowMessage("導入成功!");
            } catch (Exception $e) {
                $this->ShowMessage("導入失敗!");
                $device->rollback();
            }
        } else {
            $this->ShowMessage($up->getErrorMsg());
            $this->ShowMessage('上傳文件失敗!');
        }
        
        $this->redirect("deviceIndex");
    }

    function exportScheduling()
    {
        $title = "排 程 表";
        // 根据id查询保养排程
        $id = $_GET['id'];
        $case = $_SESSION['case'];
        $model = M('case_device_maintenance_scheduling');
        $schedul = $model->find($id);
        // 查询过期
        $sql = "SELECT o.*,t.`name` AS tname,ct.`name` AS ctname  FROM `case_device_maintenance_overtime` o INNER JOIN case_device_type t ON o.`devicetype`=t.`id` INNER JOIN case_device_child_type ct ON ct.`id`=o.`devicechildtype` WHERE o.`case` =" . $case . " AND ((o.`type`='W')OR(o.`type`='D')OR(o.`type`='M')OR(o.`startmonth`='0')OR (o.`startmonth`='" . str_replace('0', '', $schedul['month']) . "'))";
        $data = $model->query($sql);
        
        vendor('Excel.PHPExcel');
        $objPHPExcel = new PHPExcel();
        $headerkeys = array(
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'U',
            'V',
            'W',
            'X',
            'Y',
            'Z',
            'AA',
            'AB',
            'AC',
            'AD',
            'AE',
            'AF',
            'AG',
            'AH',
            'AI'
        );
        spl_autoload_register(array(
            'Think',
            'autoload'
        ));
        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        $sheet->setCellValue('A1', '排 程 表');
        $sheet->mergeCells("A1:AH1");
        $sheet->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue("A2", "類別");
        $sheet->mergeCells("A2:A3");
        $sheet->getStyle('A2')
            ->getAlignment()
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2')
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue("B2", "週期");
        $sheet->mergeCells("B2:B3");
        $sheet->getStyle('B2')
            ->getAlignment()
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B2')
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue("C2", "設備名稱");
        $sheet->mergeCells("C2:C3");
        $sheet->getStyle('C2')
            ->getAlignment()
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->getStyle('C2')
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $p = 3;
        for ($j = 1; $j < 32; $j ++) {
            if ($j < 10)
                $date = $schedul['year'] . "-" . $schedul['month'] . "-0" . $j;
            else
                $date = $schedul['year'] . "-" . $schedul['month'] . "-" . $j;
            $week = $this->getWeek($date);
            $sheet->setCellValue($headerkeys[$p] . "2", $j);
            $sheet->setCellValue($headerkeys[$p] . "3", $week);
            $sheet->getStyle($headerkeys[$p] . "2")
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle($headerkeys[$p] . "2")
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($headerkeys[$p] . "3")
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle($headerkeys[$p] . "3")
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $p ++;
        }
        // Add Data
        for ($i = 0; $i < count($data); $i ++) {
            $h = 0;
            $p = $headerkeys[$h] . ($i + 4);
            $sheet->setCellValue($headerkeys[$h] . ($i + 4), $data[$i]['tname']);
            $sheet->setCellValue($headerkeys[($h + 1)] . ($i + 4), $data[$i]['name']);
            $sheet->setCellValue($headerkeys[($h + 2)] . ($i + 4), $data[$i]['ctname']);
            $p = 3;
            for ($j = 1; $j < 32; $j ++) {
                $c = $j + 3;
                if ($j < 10)
                    $date = $schedul['year'] . "-" . $schedul['month'] . "-0" . ($j);
                else
                    $date = $schedul['year'] . "-" . $schedul['month'] . "-" . ($j);
                $sheet->setCellValue($headerkeys[$p] . $c, getY($data[$i], $date));
                $sheet->getStyle($headerkeys[$p] . $c)
                    ->getAlignment()
                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $sheet->getStyle($headerkeys[$p] . $c)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
                $p ++;
            }
        }
        $sheet->setTitle($title);
        // first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // very beautiful
        ob_end_clean();
        ob_start();
        // Redirect output to a client’s web browser (Excel5)
        $ua = $_SERVER["HTTP_USER_AGENT"];
        
        $filename = $title;
        $encoded_filename = urlencode($filename);
        $encoded_filename = str_replace("+", "%20", $encoded_filename);
        // header ( 'Content-Type: application/octet-stream' );
        header('Content-Type: application/vnd.ms-excel;charset=utf-8');
        if (preg_match("/MSIE/", $ua)) {
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
        } else 
            if (preg_match("/Firefox/", $ua)) {
                header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $filename . '"');
            }
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit();
    }

    function getWeek($d)
    {
        $weekarray = array(
            "日",
            "一",
            "二",
            "三",
            "四",
            "五",
            "六"
        );
        return $weekarray[date("w", strtotime($d))];
    }

    function content()
    {
        $id = $_GET['case'];
        // 把case的id放入session
        if (! empty($id))
            $_SESSION['case'] = $id;
        $id = $_SESSION['case'];
        $dao = M('case_content');
        $sql = "select * from case_content where id =$id";
        $data = $dao->query($sql);
        $this->assign("c", $data[0]);
        $this->display('content');
    }

    function saveContent()
    {
        $id = $_SESSION['case'];
        $dao = M('case_content');
        $data = $dao->create();
        $this->UpLoadFile(ATTCHEMENT_PATH_CASEFILE, $data);
        if (empty($data['id'])) {
            $data['id'] = $id;
            $dao->add($data);
        } else {
            $dao->save($data);
        }
        $this->redirect('content');
    }

    function editContent()
    {
        $id = $_SESSION['case'];
        $dao = M('case_content');
        $sql = "select * from case_content where id =$id";
        $data = $dao->query($sql);
        $this->assign("c", $data[0]);
        $this->display('contentEdit');
    }

    function DeleteDeviceByCase()
    {
        $case = $_GET['case'];
        $dao = new Model();
        $dao->execute("DELETE FROM case_device WHERE `case` = " . $case);
        $this->redirect("deviceIndex");
    }

    function moveshift()
    {
        $dao = M('case_moveshift');
        $this->table_page($dao, "`case`=" . $_SESSION['case']);
        $this->display('moveshift');
    }

    function addworkshift()
    {
        $this->assign("date", date('Y-m-d'));
        // 查询专案人员
        $dao = new Model();
        $users = $dao->query("SELECT u.* FROM case_member  m INNER JOIN `user` u ON m.`memberid`=u.`id` WHERE `case`= " . $_SESSION['case']);
        $this->assign("users", $users);
        // 查询班别
        $works = $dao->query("SELECT * FROM case_work WHERE `case`= " . $_SESSION['case']);
        $this->assign("works", $works);
        
        $this->display('addworkshift');
    }

    function insertWorkShift()
    {
        // 保存主表
        $move = M('case_moveshift');
        try {
            $move->startTrans();
            $data = $move->create();
            $id = $data['id'];
            if (empty($id)) {
                $id = $move->add($data);
                $this->addWorkShiftDetail($id, false);
            } else {
                $move->save($data);
                $this->addWorkShiftDetail($id, true);
            }
            $move->commit();
        } catch (Exception $e) {
            $move->rollback();
        }
        $this->redirect("moveshift");
    }

    function addWorkShiftDetail($id, $isUpdate)
    {
        $md = M('case_moveshift_detail');
        if ($isUpdate)
            $md->where('moveid =' . $id)->delete();
        $details = $_POST['detail'];
        if (! empty($details)) {
            foreach ($details as $key => $value) {
                $datas = explode(",", $value);
                $data['moveid'] = $id;
                $data['username'] = $datas['0'];
                $data['movetime'] = $datas['1'];
                $data['oldworktype'] = $datas['2'];
                $data['newworktype'] = $datas['3'];
                $md->add($data);
            }
        }
    }

    function workShiftUpdate()
    {
        $dao = M('case_moveshift');
        $id = $_GET['id'];
        $move = $dao->find($id);
        $this->assign("move", $move);
        $details = $dao->query("SELECT * FROM case_moveshift_detail where moveid=$id");
        $this->assign("details", $details);
        
        $this->assign("date", date('Y-m-d'));
        // 查询专案人员
        $dao = new Model();
        $users = $dao->query("SELECT u.* FROM case_member  m INNER JOIN `user` u ON m.`memberid`=u.`id` WHERE `case`= " . $_SESSION['case']);
        $this->assign("users", $users);
        // 查询班别
        $works = $dao->query("SELECT * FROM case_work WHERE `case`= " . $_SESSION['case']);
        $this->assign("works", $works);
        
        $this->display('updateworkshift');
    }

    function workShiftView()
    {
        $dao = M('case_moveshift');
        $id = $_GET['id'];
        $move = $dao->find($id);
        $this->assign("move", $move);
        $details = $dao->query("SELECT * FROM case_moveshift_detail where moveid=$id");
        $this->assign("details", $details);
        $this->display('workshiftview');
    }

    function workShiftDelete()
    {
        $dao = M('case_moveshift');
        $id = $_GET['id'];
        $dao->delete($id);
        $dao->execute("DELETE FROM case_moveshift_detail where moveid=$id");
        $this->redirect("moveshift");
    }

    function attendanceExport()
    {
        $id = $_GET['id'];
        $year = $_GET['year'];
        $month = $_GET['month'];
        $sql = "	SELECT
			a.`username`,
			DATE(c.`date`),
			TIME(c.`ontime`),
			TIME(c.`downtime`),
			a.`workcode`
			FROM
			`case_attendance_detail` a
			LEFT JOIN `check` c
			ON DATEDIFF(
			CONCAT('$year-$month-', a.`day`),
			c.`date`
			) = 0
			AND a.`userid` = c.`uid`
			WHERE a.attendance = $id";
        $dao = new Model();
        $list = $dao->query($sql);
        $downName = '差勤列表';
        $headers = '姓名,時間,上班時間,下班時間,班別';
        $this->cvsDown($list, $headers, $downName);
    }
}
?>