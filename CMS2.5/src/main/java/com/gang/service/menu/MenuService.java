package com.gang.service.menu;

import java.util.HashSet;
import java.util.List;
import java.util.Set;

import org.apache.struts2.ServletActionContext;
import org.hibernate.Query;
import org.hibernate.transform.ResultTransformer;
import org.springframework.orm.hibernate3.LocalSessionFactoryBean;
import org.springframework.web.context.support.WebApplicationContextUtils;

import com.gang.comms.JSONHelper;
import com.gang.comms.SetValue;
import com.gang.comms.SpringContextUtil;
import com.gang.entity.menu.Menu;
import com.gang.service.BaseService;

@SuppressWarnings("unchecked")
public class MenuService extends BaseService {

	class SQLResultTransformer implements ResultTransformer{
		private static final long serialVersionUID = 1L;
		private String menuIds;
		public SQLResultTransformer(String menuIds) {
			super();
			this.menuIds = menuIds;
		}
		@Override
		public List transformList(List list) {
			return list;
		}
		@Override
		public Object transformTuple(Object[] values, String[] fields) {
			Menu m = new Menu();
			for(int i=0; i<fields.length; ++i){
				fields[i] = fields[i].toLowerCase();
				if("id".equals(fields[i])){
					SetValue.setValue(m, fields[i], Integer.parseInt(values[i].toString()));
					m.setChildren(getChilder(m.getId(), menuIds));
				}
				else if("name".equals(fields[i])){
					SetValue.setValue(m, fields[i], values[i]);
				}
				else if("checked".equals(fields[i])){
					//最下级
					if(m.getChildren().size() == 0){
						SetValue.setValue(m, fields[i], !values[i].toString().equals("0"));
					}
				}
			}
			return m;
		}
	}
	public Set<Menu> getChilder(Integer parentId, String menuIds){
		if(menuIds == null){
			menuIds = ",";
		}
		//String sql = "SELECT menu.*, INSTR(?, ','||id||',') as checked FROM menu WHERE parentId=? ORDER BY id ASC";//oracle
		//String sql = "SELECT menu.*, LOCATE(CONCAT(',', id, ','), ?) as checked FROM menu WHERE parentId=? ORDER BY id ASC";//mysql
		String sql = getSql() + "WHERE parentId=? ORDER BY id ASC";
		return new HashSet<Menu>(getSession().createSQLQuery(sql).setString(0, menuIds).setInteger(1, parentId).setResultTransformer(new SQLResultTransformer(menuIds)).list());
	}
	
	public String getMenuTreeJSON(String menuIds)
	{
		if(menuIds == null){
			menuIds = ",";
		}
		//String sql = "SELECT menu.*, INSTR(?, ','||id||',') as checked FROM menu WHERE parentId IS NULL ORDER BY id ASC";//oracle
		//String sql = "SELECT menu.*, LOCATE(CONCAT(',', id, ','), ?) as checked FROM menu WHERE parentId IS NULL ORDER BY id ASC";//mysql
		String sql = getSql();
		if(null == sql){
			return "";
		}
		sql += "WHERE parentId IS NULL ORDER BY id ASC";
		Query query = getSession().createSQLQuery(sql).setString(0, menuIds);
		query.setResultTransformer(new SQLResultTransformer(menuIds));
		List<Menu> menus=query.list();//getCriteria(Menu.class).add(Restrictions.isNull("parent")).list();
		String json=JSONHelper.SerializeWithNeedAnnotationNone(menus);
		//System.out.println(json + "\n" + getSql());
		return json;
	}
	
	private String getSql(){
		String dialect = getDialect();
		if("com.gang.comms.CMSMySQLDialect".equals(dialect)){
			return "SELECT menu.*, LOCATE(CONCAT(',', id, ','), ?) as checked FROM menu ";
		}
		else if("org.hibernate.dialect.OracleDialect".equals(dialect)){
			return "SELECT menu.*, INSTR(?, ','||id||',') as checked FROM menu ";
		}
		return null;
	}
	
	private String getDialect(){
		LocalSessionFactoryBean lsfb = (LocalSessionFactoryBean)WebApplicationContextUtils.getWebApplicationContext(ServletActionContext.getServletContext()).getBean("&sessionFactory");
		return lsfb.getHibernateProperties().getProperty("hibernate.dialect");
	}
}
