package com.gang.service.role;

import org.hibernate.Hibernate;
import org.hibernate.Session;

import com.gang.entity.role.Role;
import com.gang.service.BaseService;

public class RoleService extends BaseService {
	public void saveRole(Role role) {
		save(role);
	}

	public void deleteRole(Integer id) {
		Role r = new Role();
		r.setId(id);
		getSession().delete(r);
	}

	public Role getRoleById(Integer id) {
		Role role = (Role) get(Role.class, id);
		Hibernate.initialize(role.getSection());
		return (Role) get(Role.class, id);
	}

	public void update(Role role) {
		Session session = getSession();
		Role oldRole = (Role) session.get(Role.class, role.getId());
		oldRole.setName(role.getName());
		oldRole.setSection(role.getSection());
		oldRole.setType(role.getType());
		oldRole.setMenus(role.getMenus());
	}

	public void deleteRoles(Integer[] ids) {
		for (Integer id : ids) {
			delete(Role.class,id);
		}
		// String hql = "DELETE FROM Role WHERE id in (:ids)";
		// getSession().createQuery(hql).setParameterList("ids",
		// ids).executeUpdate();
	}
}
