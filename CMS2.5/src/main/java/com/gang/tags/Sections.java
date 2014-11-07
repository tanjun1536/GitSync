package com.gang.tags;

import java.io.IOException;
import java.util.Set;

import javax.servlet.http.HttpSession;
import javax.servlet.jsp.JspException;
import javax.servlet.jsp.tagext.TagSupport;

import org.springframework.context.ApplicationContext;
import org.springframework.web.context.support.WebApplicationContextUtils;

import com.gang.entity.section.Section;
import com.gang.entity.user.BackUser;
import com.gang.service.user.BackUserService;

public class Sections extends TagSupport{

	private static final long serialVersionUID = 1L;
	private static final String START_TAG = "<select id=\"%s\" name=\"%s\" style=\"%s\">";
	private static final String OPTION_TAG = "<option value=\"%s\">%s</option>";
	private static final String END_TAG = "</select>";
	
	private String id = "";
	private String name = "";
	private String style = "";
	private String sessName;
	
	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getStyle() {
		return style;
	}

	public void setStyle(String style) {
		this.style = style;
	}

	private void out(String text){
		try {
			pageContext.getOut().println(text);
		} catch (IOException e) {
			throw new RuntimeException(e);
		}
	}
	
	private BackUserService getService(){
		ApplicationContext context = WebApplicationContextUtils.getWebApplicationContext(pageContext.getServletContext());
		BackUserService service = (BackUserService)context.getBean("BackUserService");
		return service;
	}
	
	private BackUser getUser(){
		HttpSession session = pageContext.getSession();
		return (BackUser)session.getAttribute(sessName);
	}
	
	protected void execute(){
		Set<Section> sections = getService().getBackUserSections(getUser().getId());
		begin();
		for (Section section : sections) {
			addOption(String.valueOf(section.getId()), section.getName());
		}
		end();
	}
	
	/**
	 * 开始执行输入
	 */
	protected void begin(){
		out(String.format(START_TAG, id, name, style));
	}
	/**
	 * 加入选项
	 */
	protected void addOption(String value, String label){
		out(String.format(OPTION_TAG, value, label));
	}
	/**
	 * 结束执行输入
	 */
	protected void end(){
		out(END_TAG);
	}
	
	@Override
	public int doEndTag() throws JspException {
		execute();
		return SKIP_BODY;
	}

	@Override
	public int doStartTag() throws JspException {
		return super.doStartTag();
	}

	public String getSessName() {
		return sessName;
	}

	public void setSessName(String sessName) {
		this.sessName = sessName;
	}

}
