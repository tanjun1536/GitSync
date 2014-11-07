package com.gang.action.menu;

import com.gang.action.DefaultAction;
import com.gang.service.menu.MenuService;

public class MenuAction extends DefaultAction {

	private static final long serialVersionUID = 1L;
	private MenuService service;
	private String menuIds;
	

	public void setMenuIds(String menuIds) {
		this.menuIds = menuIds;
	}

	public void getMenuTreeJson() throws Exception{
		Write(service.getMenuTreeJSON(menuIds));
	}
	
	public void setService(MenuService service) {
		this.service = service;
	}

}
