package com.gang.action.role;

import java.util.List;
import java.util.Set;

import javax.servlet.http.HttpServletRequest;

import org.springframework.orm.hibernate3.LocalSessionFactoryBean;

import com.gang.action.BaseAction;
import com.gang.action.DefaultAction;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.dict.Dict;
import com.gang.entity.menu.Menu;
import com.gang.entity.role.Role;
import com.gang.service.dict.DictService;
import com.gang.service.menu.MenuService;
import com.gang.service.role.RoleService;

public class RoleAction extends DefaultAction {
	private static final long serialVersionUID = 1L;
	private RoleService service;
	private DictService dictService;
	private MenuService menuService;
	private Role role;
	public Role getRole() {
		return role;
	}

	public void setRole(Role role) {
		this.role = role;
	}

	public void setService(RoleService service) {
		this.service = service;
	}
	
	public void getRoleList() throws Exception {
		getList();
	}
	
	public String add(){
		// 获取req
		HttpServletRequest req = getRequest();
		// 加载角色等级
		List<Dict> dicts = dictService.getDictByCategory("角色级别");
		req.setAttribute("dicts", dicts);
//		List<Menu> menus = menuService.getList(Menu.class);
//		req.setAttribute("menus", menus);
		return ADD;
	}

	public String addRole() throws Exception{
		return save();
	}
	
	public String edit() throws Exception {
		HttpServletRequest req = getRequest();
		Integer id = getId();
		role = (Role)service.get(Role.class, id, "getMenus");
		List<Dict> dicts = dictService.getDictByCategory("角色级别");
		req.setAttribute("dicts", dicts);
//		List<Menu> menus = menuService.getList(Menu.class);
		//设置选择角色已有的功能
//		_A:for (Menu menu : menus) {
//			for(Menu rMenu : role.getMenus()){
//				if(menu.getId().equals(rMenu.getId())){
//					menu.setSelected(true);
//					continue _A;
//				}
//			}
//		}
//		req.setAttribute("menus", menus);
		String menuIds = ",";
		for(Menu rMenu : role.getMenus()){
			menuIds += rMenu.getId() + ",";
		}
		req.setAttribute("menuIds", menuIds);
		return EDIT;
	}
	
	public String updateRole() throws Exception {
		return update();
	}
	
	public String deleteList() {
		String[] idArr = getRequest().getParameter("ids").split(",");
		Integer[] ids = new Integer[idArr.length];
		for(int i=0; i<idArr.length; ++i){
			ids[i] = Integer.parseInt(idArr[i]);
		}
		service.deleteRoles(ids);
		return LIST;
	}
	

	public String delete() {
		Integer id = getId();
		service.deleteRole(id);
		return LIST;
	}
	
	public void setDictService(DictService dictService) {
		this.dictService = dictService;
	}

	public void setMenuService(MenuService menuService) {
		this.menuService = menuService;
	}


	@Override
	public void getList() throws Exception {
		GridPageRequest gr = new GridPageRequest(getRequest());
		gr.setCsql("SELECT COUNT(*) FROM Role ");
		gr.setDsql("FROM Role ");
		gr.setHsql(true);
//		gr.setClazz(Role.class);
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	@Override
	public String save() throws Exception {
		String[] memuIds = getRequest().getParameterValues("menus");
		Set<Menu> menus = new java.util.HashSet<Menu>();
		for(String menuId : memuIds){
			Menu menu = new Menu();
			menu.setId(Integer.parseInt(menuId));
			menus.add(menu);
		}
		role.setMenus(menus);
		service.add(role);
		return LIST;
	}

	@Override
	public String update() throws Exception {
		String[] memuIds = getRequest().getParameterValues("menus");
		if(memuIds != null){
			Set<Menu> menus = new java.util.HashSet<Menu>();
			for(String menuId : memuIds){
				Menu menu = new Menu();
				menu.setId(Integer.parseInt(menuId));
				menus.add(menu);
			}
			role.setMenus(menus);
		}
		service.update(role);
		role = null;
		return LIST;
	}
}
