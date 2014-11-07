package com.gang.service.user;

import java.util.Comparator;
import java.util.List;
import java.util.Set;
import java.util.TreeSet;

import org.hibernate.Hibernate;
import org.hibernate.Session;
import org.hibernate.criterion.Restrictions;

import com.gang.entity.role.Role;
import com.gang.entity.section.Section;
import com.gang.entity.user.BackUser;
import com.gang.service.BaseService;


public class BackUserService extends BaseService{
	public void deleteBackUser(Integer id)
	{
		//delete(BackUser.class, id);
		Session session=getSession();
//		session.createSQLQuery("DELETE FROM debugger").executeUpdate();
		BackUser user = new BackUser();
		user.setId(id);
		session.delete(user);
//		session.createSQLQuery("INSERT INTO debugger(debugger) select id FROM backuser_role").executeUpdate();
	}
	public void changeUserState(Integer id)
	{
		Session session=getSession();
		BackUser user=(BackUser) session.get(BackUser.class, id);
		user.setDisabled(!user.getDisabled());
	}
	public void deleteBackUsers(Integer[] ids)
	{
		for (Integer id : ids) {
			try {
				deleteBackUser(id);
			} catch (IllegalArgumentException e) {
				//e.printStackTrace();
			}
		}
	}
	
	public BackUser getBackUserById(Integer id){
		BackUser user = (BackUser)get(BackUser.class, id);
		return user;
	}
	
	public void update(BackUser user){
		Session session = getSession();
		BackUser oldUser = (BackUser)session.get(BackUser.class, user.getId());
		oldUser.setName(user.getName());
		oldUser.setDepartment(user.getDepartment());
		oldUser.setLoginName(user.getLoginName());
		oldUser.setLoginPassword(user.getLoginPassword());
		oldUser.getRoles().clear();
		oldUser.getRoles().addAll(getRoles(user.getRoles().toArray(new Role[]{})));
	}
	
	@SuppressWarnings("unchecked")
	private List<Role> getRoles(Role[] roles){
		Integer[] ids = new Integer[roles.length];
		for (int i=0; i<roles.length; i++) {
			ids[i] = roles[i].getId();
		}
		return getCriteria(Role.class).add(Restrictions.in("id", ids)).list();
	}
	
	/**
	 * 查询用户所管理的栏目
	 * @param userId
	 * @return
	 */
	public Set<Section> getBackUserSections(int userId){
		BackUser user = (BackUser)getSession().createCriteria(BackUser.class).add(Restrictions.idEq(userId)).uniqueResult();
		if(user == null){
			return new TreeSet<Section>();
		}
		Hibernate.initialize(user.getRoles());
		Set<Role> roles = user.getRoles();
		Comparator<Section> c = new Comparator<Section>(){
			@Override
			public int compare(Section o1, Section o2) {
				System.out.println(o1 + "  " + o2);
				return o1.getName().compareTo(o2.getName());
			}};
		Set<Section> sections = new TreeSet<Section>(c);
		for (Role role : roles) {
			sections.add(role.getSection()); 
		}
		return sections;
	}

	public void alterPwd(BackUser bkUser, String pwd) {
		BackUser bu=get(BackUser.class,bkUser.getId());
		bu.setLoginPassword(pwd);
	}
}
