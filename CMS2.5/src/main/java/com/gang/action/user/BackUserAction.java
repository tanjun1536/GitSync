package com.gang.action.user;

import com.gang.action.BaseAction;
import com.gang.action.DefaultAction;

import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;

import com.gang.entity.department.Department;
import com.gang.entity.menu.Menu;
import com.gang.entity.role.Role;
import com.gang.entity.user.BackUser;

import com.gang.service.department.DepartmentService;
import com.gang.service.role.RoleService;
import com.gang.service.user.BackUserService;

import java.util.List;
import java.util.Set;

import javax.servlet.http.HttpServletRequest;

public class BackUserAction extends DefaultAction {
	// ~ Static fields/initializers
	// -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private static final long serialVersionUID = 1L;

	// ~ Instance fields
	// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private BackUserService service;
	private DepartmentService departmentService;
	private RoleService roleService;
	private BackUser user;

	// ~ Methods
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public void getBackUserList() throws Exception {
		getList();
	}

	public String add() {
		HttpServletRequest req = getRequest();

		List<Role> roles = roleService.getList(Role.class);
		req.setAttribute("roles", roles);

		return ADD;
	}

	public String addBackUser() throws Exception {
		return save();
	}

	public String deleteList() {
		String[] idArr = getRequest().getParameter("ids").split(",");
		Integer[] ids = new Integer[idArr.length];

		for (int i = 0; i < idArr.length; ++i) {
			ids[i] = Integer.parseInt(idArr[i]);
		}

		service.deleteBackUsers(ids);

		return LIST;
	}

	@Override
	public void delete(Integer id) throws Exception {
		service.deleteBackUser(id);
	}

	public String changeUserState() {
		service.changeUserState(getId());
		return LIST;
	}

	@Override
	public void edit(Integer id, HttpServletRequest req) throws Exception {
		user = (BackUser) service.get(BackUser.class, id, "getRoles");

		List<Role> roles = roleService.getList(Role.class);

		_A: for (Role role : roles) {
			for (Role uRole : user.getRoles()) {
				if (role.getId().equals(uRole.getId())) {
					role.setSelected(true);

					continue _A;
				}
			}
		}

		req.setAttribute("roles", roles);
	}

	public String updateBackUser() throws Exception {
		return update();
	}

	public BackUser getUser() {
		return user;
	}

	public void setUser(BackUser user) {
		this.user = user;
	}

	public void setService(BackUserService service) {
		this.service = service;
	}

	public void setDepartmentService(DepartmentService departmentService) {
		this.departmentService = departmentService;
	}

	public void setRoleService(RoleService roleService) {
		this.roleService = roleService;
	}

	@Override
	public void getList() throws Exception {
		GridPageRequest gr = new GridPageRequest(getRequest());

		if ((user != null) && (user.getDepartment() != null)
				&& (user.getDepartment().getId() != null)) {
			gr.setCsql("SELECT COUNT(*) FROM BackUser WHERE department.id="
					+ user.getDepartment().getId());
			gr.setDsql("FROM BackUser WHERE department.id="
					+ user.getDepartment().getId());
		} else {
			gr.setCsql("SELECT COUNT(*) FROM BackUser ");
			gr.setDsql("FROM BackUser ");
		}

		gr.setHsql(true);
		gr.addCglibProperty("getDepartment",
				new GridPageRequest.AddCglibPropertyHandler() {
					@Override
					public void handler(Object unprox) {
						Department department = (Department) unprox;
						department.setChildren(null);
					}
				});

		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	@Override
	public void doSave() throws Exception {
		if ((user.getDepartment() == null)
				|| (user.getDepartment().getId() == null)) {
			user.setDepartment(null);
		}

		String[] roleIds = getRequest().getParameterValues("roles");
		Set<Role> roles = new java.util.HashSet<Role>();

		if (roleIds == null) {
			roleIds = new String[0];
		}

		for (String roleId : roleIds) {
			Role role = new Role();
			role.setId(Integer.parseInt(roleId));
			roles.add(role);
		}

		user.setRoles(roles);
		service.add(user);
	}

	@Override
	public void doUpdate() throws Exception {
		if ((user.getDepartment() == null)
				|| (user.getDepartment().getId() == null)) {
			user.setDepartment(null);
		}

		String[] roleIds = getRequest().getParameterValues("roles");
		Set<Role> roles = new java.util.HashSet<Role>();

		if (roleIds == null) {
			roleIds = new String[0];
		}

		for (String roleId : roleIds) {
			Role role = new Role();
			role.setId(Integer.parseInt(roleId));
			roles.add(role);
		}

		user.setRoles(roles);
		service.update(user);
		user = null;
	}

	public void alterPwd() {
		try {
			String pwd = getString("pwd");
			BackUser bkUser = getBackUser();
			service.alterPwd(bkUser, pwd);
			Write(OK);
		} catch (Exception e) {
			Write(NO);
		}
	}
}
