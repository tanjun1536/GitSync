package com.gang.service.system;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import javax.servlet.http.HttpSession;

import org.hibernate.SQLQuery;

import com.gang.action.BaseAction;
import com.gang.comms.BackUserProxy;
import com.gang.comms.CollectionHelper;
import com.gang.entity.menu.Menu;
import com.gang.entity.user.BackUser;
import com.gang.service.BaseService;

public class SystemService extends BaseService {
	public String getSystemMenu(Integer[] roleIds) {
		StringBuilder sb = new StringBuilder();
		List<Menu> menus =CollectionHelper.getList(getMenus(roleIds));//this.getParent(Menu.class);
		// 获取第一层菜单
		
		for (Menu m : menus) {
			if (m.getParent() == null)// 第一层菜单
			{
				sb.append("<li class=\"dh\"><img src=\"images/menuHeadLeftImg.png\" align=\"absmiddle\" style=\"margin-left: 5px\">&nbsp;");
				sb.append( m.getName() );
				sb.append("</li>");
				List<Menu> children =CollectionHelper.getList( this.getChild(menus, m.getId()));
				if (children != null && children.size() > 0) {//第二层菜单
					for (Menu cm : children) {
						sb.append("<li class=\"dd\"><img src=\"images/menuLeftImg.png\" align=\"absmiddle\" style=\"margin-left: 5px;margin-top:3px;\">&nbsp;<a href=\""+cm.getLink()+"\">"+cm.getName()+"</a></li>");
					}
				}
			}
		}
		return sb.toString();
	}

	private List<Menu> getChild(List<Menu> menus, Integer paretnId) {
		List<Menu> ms = new ArrayList<Menu>();
		for (Menu m : menus) {
			if (m.getParent() != null && m.getParent().getId().equals(paretnId)) {
				ms.add(m);
			}
		}
		return ms;
	}
	public Integer[] getRoleIds(HttpSession session){
		BackUser user = (BackUser)session.getAttribute(BaseAction.SESSION_BACK_USER);
		return new BackUserProxy(user).getRoleIds();
	}
	public List<Menu> getMenus(Integer[] roleIds){
		System.out.println(Arrays.toString(roleIds));
		String sql = "SELECT id, name, link, image, orderNumber, parentId FROM menu WHERE id in(SELECT MenuId FROM role_menu WHERE RoleId IN(:ids) GROUP BY MenuId)";
		SQLQuery query = getSession().createSQLQuery(sql);
		return CollectionHelper.getList(query.addEntity(Menu.class).setParameterList("ids", roleIds).list());
	}
}
