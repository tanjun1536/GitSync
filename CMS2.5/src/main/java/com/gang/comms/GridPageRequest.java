package com.gang.comms;

import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;

import org.hibernate.transform.ResultTransformer;

public class GridPageRequest {

	public static abstract class AddCglibPropertyHandler {
		public abstract void handler(Object unprox);
	}

	public interface AddLazyPropertyHandler {
		public void handler(Object list);
	}

	private List<String> cglibProperties = new ArrayList<String>();
	private Class clazz;
	private String csql;
	private String dsql;
	private Map<String, AddCglibPropertyHandler> handlers = new HashMap<String, AddCglibPropertyHandler>();
	private boolean isGetAll;
	private boolean isHsql = false;
	private boolean isOrderBy = true;

	public boolean isOrderBy() {
		return isOrderBy;
	}

	public void setOrderBy(boolean isOrderBy) {
		this.isOrderBy = isOrderBy;
	}

	private List<String> lazyProperties = new ArrayList<String>();
	private Map<String, AddLazyPropertyHandler> lazyHandlers = new HashMap<String, AddLazyPropertyHandler>();
	private boolean userResultTransformer = false;

	public boolean isUserResultTransformer() {
		return userResultTransformer;
	}

	public void setUserResultTransformer(boolean userResultTransformer) {
		this.userResultTransformer = userResultTransformer;
	}

	private String orderColumn;
	private String orderType;
	private int pageIndex = 1;
	private int pageSize = 20;

	private Map<String, Date> queryDateProperties = new HashMap<String, Date>(2);

	/**
	 * 用来控制查询的时候二义性
	 */
	private String tableAlias;

	public GridPageRequest() {

	}

	public GridPageRequest(HttpServletRequest req) {

		setPageIndex(Integer.parseInt(req.getParameter("page")));
		setPageSize(Integer.parseInt(req.getParameter("rows")));
		setOrderColumn(req.getParameter("sidx"));
		setOrderType(req.getParameter("sord"));
	}

	public GridPageRequest addCglibProperty(String prop) {
		this.cglibProperties.add(prop);
		return this;
	}

	public GridPageRequest addCglibProperty(String prop,
			AddCglibPropertyHandler handler) {
		this.cglibProperties.add(prop);
		this.handlers.put(prop, handler);
		return this;
	}

	public GridPageRequest addLazyProperty(String prop) {
		this.lazyProperties.add(prop);
		return this;
	}

	public GridPageRequest addLazyProperty(String prop,
			AddLazyPropertyHandler handler) {
		this.lazyProperties.add(prop);
		this.lazyHandlers.put(prop, handler);
		return this;
	}

	public List<String> getCglibProperties() {
		return cglibProperties;
	}

	public AddCglibPropertyHandler getCglibPropertyHandler(String prop) {
		return this.handlers.get(prop);
	}

	public AddLazyPropertyHandler getLazyPropertyHandler(String prop) {
		return this.lazyHandlers.get(prop);
	}

	public Class getClazz() {
		return clazz;
	}

	public String getCsql() {
		return csql;
	}

	public String getDsql() {
		return dsql;
	}

	public Map<String, AddCglibPropertyHandler> getHandlers() {
		return handlers;
	}

	public List<String> getLazyProperties() {
		return lazyProperties;
	}

	public String getOrderColumn() {
		return orderColumn;
	}

	public String getOrderType() {
		return orderType;
	}

	public int getPageIndex() {
		return pageIndex;
	}

	public int getPageSize() {
		return pageSize;
	}

	public Map<String, Date> getQueryDateProperties() {
		return queryDateProperties;
	}

	public int getStartNumber() {
		return (pageIndex - 1) * pageSize;
	}

	public String getTableAlias() {
		return tableAlias == null ? "" : tableAlias + ".";
	}

	public boolean isGetAll() {
		return isGetAll;
	}

	public boolean isHsql() {
		return isHsql;
	}

	public void setCglibProperties(List<String> cglibProperties) {
		this.cglibProperties = cglibProperties;
	}

	public void setClazz(Class clazz) {
		this.clazz = clazz;
	}

	public void setCsql(String csql) {
		this.csql = csql;
	}

	public void setDsql(String dsql) {
		this.dsql = dsql;
		if (orderColumn != null) {
			if (isOrderBy)
				this.dsql += " ORDER BY " + getTableAlias() + orderColumn + " "
						+ orderType;
		}
	}

	public void setGetAll(boolean isGetAll) {
		this.isGetAll = isGetAll;
	}

	public void setHandlers(Map<String, AddCglibPropertyHandler> handlers) {
		this.handlers = handlers;
	}

	public void setHsql(boolean isHsql) {
		this.isHsql = isHsql;
	}

	public void setLazyProperties(List<String> lazyProperties) {
		this.lazyProperties = lazyProperties;
	}

	public void setOrderColumn(String orderColumn) {
		this.orderColumn = orderColumn;
	}

	public void setOrderType(String orderType) {
		this.orderType = orderType;
	}

	public void setPageIndex(int pageIndex) {
		this.pageIndex = pageIndex;
	}

	public void setPageSize(int pageSize) {
		this.pageSize = pageSize;
	}

	public void setQueryDateProperties(Map<String, Date> queryDateProperties) {
		this.queryDateProperties = queryDateProperties;
	}

	public void setTableAlias(String tableAlias) {
		this.tableAlias = tableAlias;
	}
}
