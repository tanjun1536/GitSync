package com.gang.service.department;

import java.util.List;
import java.util.Vector;

import org.hibernate.Hibernate;
import org.hibernate.Session;
import org.hibernate.criterion.Restrictions;

import com.gang.comms.JSONHelper;
import com.gang.entity.department.Department;
import com.gang.entity.section.Section;
import com.gang.service.BaseService;


public class DepartmentService extends BaseService{
	public void deleteDepartment(Integer id)
	{
		delete( Department.class,id);
	}
	
	public void deleteDepartments(Integer[] ids)
	{
		for (Integer id : ids) {
			try {
				delete( Department.class,id);
			} catch (IllegalArgumentException e) {
				//e.printStackTrace();
			}
		}
	}
	
	public Department getDepartmentById(Integer id){
		Department depart = (Department)get(Department.class, id);
		return depart;
	}
	
	public void update(Department depart){
		Session session = getSession();
		Department olddepart = (Department)session.get(Department.class, depart.getId());
		olddepart.setName(depart.getName());
	}
	
	public List<Department> getSortDeparts(List<Department> departs){
		List<Department> sotrDeparts = new Vector<Department>();
		sortDeparts(departs, sotrDeparts, null, 1);
		return sotrDeparts;
	}

	private void sortDeparts(List<Department> src, List<Department> dest, Integer parentId, int level){
		for (Department depart : src) {
			if(depart.getParentId() == parentId){
				depart.setName(depart.getStartTagStr("-") + depart.getName());
				dest.add(depart);
				sortDeparts(src, dest, depart.getId(), level++);
			}
		}
	}
	
	public String getDepartmentTreeJSON()
	{
		List<Department> departments=getCriteria(Department.class).add(Restrictions.isNull("parent")).list();
		String json=JSONHelper.SerializeWithNeedAnnotation(departments);
		return json;
	}
}
