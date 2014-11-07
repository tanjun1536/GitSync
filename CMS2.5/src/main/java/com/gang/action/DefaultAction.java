package com.gang.action;

import javax.servlet.http.HttpServletRequest;

import org.acegisecurity.providers.encoding.Md5PasswordEncoder;

import com.gang.service.BaseService;
import com.gang.service.wssvc.Generator;
import com.gang.service.wssvc.JSONGenerator;

public class DefaultAction extends BaseAction {
	
	
    
	// ~ Static fields/initializers
	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private static final long serialVersionUID = 1L;

	// ~ Instance fields
	// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	protected Class entityClass;

	// ~ Methods
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public Class getEntityClass() {
		return entityClass;
	}

	public void setEntityClass(Class entityClass) {
		this.entityClass = entityClass;
	}

	public void getList() throws Exception {
	}

	public String add() throws Exception {
		add(getRequest());
		return ADD;
	}

	public String save() throws Exception {
		doSave();

		return LIST;
	}

	public String edit() throws Exception {
		edit(getId(), getRequest());

		return EDIT;
	}

	public String update() throws Exception {
		doUpdate();

		return LIST;
	}

	public void ajaxDelete() throws Exception {
		ajaxDelete(getId());
	}

	public String delete() throws Exception {
		delete(getId());

		return LIST;
	}

	public void add(HttpServletRequest req) throws Exception {
	}

	public void doSave() throws Exception {
	}

	public void doUpdate() throws Exception {
	}

	public void edit(Integer id, HttpServletRequest req) throws Exception {
	}

	public void ajaxDelete(Integer id) throws Exception {

	}

	public void delete(Integer id) throws Exception {
	}

	public String audit() throws Exception {
		audit(getId());
		return AUDIT;
	}

	public void audit(Integer id) throws Exception {
	}
}
