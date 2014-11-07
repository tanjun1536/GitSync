package com.gang.action.department;

import javax.servlet.http.HttpServletRequest;

import com.gang.action.BaseAction;
import com.gang.action.DefaultAction;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.department.Department;
import com.gang.service.department.DepartmentService;

public class DepartmentAction extends DefaultAction{
	private static final long serialVersionUID = 1L;
	private DepartmentService service;
	private Department depart;
	
	public void getDepartmentList() throws Exception {
		getList();
	}
	
	public void getDepartmentTreeJSON() throws Exception {
		String json = service.getDepartmentTreeJSON();
		System.out.println(json);
		Write(json);
	}
	
	public String add(){
		// 获取req
		HttpServletRequest req = getRequest();
//		List<Department> departs = service.getList(Department.class);
//		req.setAttribute("departs", service.getSortDeparts(departs));
		return ADD;
	}
	
	public String addDepartment() throws Exception{
		return save();
	}
	
	public String deleteList() {
		String[] idArr = getRequest().getParameter("ids").split(",");
		Integer[] ids = new Integer[idArr.length];
		for(int i=0; i<idArr.length; ++i){
			ids[i] = Integer.parseInt(idArr[i]);
		}
		service.deleteDepartments(ids);
		return LIST;
	}
	
	public String delete() {
		Integer id = getId();
		service.deleteDepartment(id);
		return LIST;
	}
	
	public String edit() throws Exception {
		HttpServletRequest req = getRequest();
		Integer id = getId();
		depart = (Department)service.get(Department.class, id);
//		List<Department> departs = service.getList(Department.class);
//		req.setAttribute("departs", departs);
		return EDIT;
	}
	
	public String updateDepartment() throws Exception {
		return update();
	}
	
	public DepartmentService getService() {
		return service;
	}
	public void setService(DepartmentService service) {
		this.service = service;
	}

	public Department getDepart() {
		return depart;
	}

	public void setDepart(Department depart) {
		this.depart = depart;
	}

	@Override
	public void getList() throws Exception {
		GridPageRequest gr = new GridPageRequest(getRequest());
		if(depart != null && depart.getParent() != null && depart.getParent().getId() != null){
			gr.setCsql("SELECT COUNT(*) FROM Department WHERE id=" + depart.getParent().getId() +" OR parent.id=" + depart.getParent().getId());
			gr.setDsql("FROM Department WHERE id=" + depart.getParent().getId() +" OR parent.id=" + depart.getParent().getId());
		}
		else{
			gr.setCsql("SELECT COUNT(*) FROM Department ");
			gr.setDsql("FROM Department ");
		}
		gr.setHsql(true);
		gr.addLazyProperty("getChildren");
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	@Override
	public String save() throws Exception {
		if(depart.getParent().getId() == -1){
			depart.setParent(null);
		}
		service.add(depart);
		return LIST;
	}

	@Override
	public String update() throws Exception {
		service.update(depart);
		depart = null;
		return LIST;
	}
}
