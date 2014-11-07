<%@page import="javax.script.Bindings"%>
<%@page import="com.gang.entity.article.ArticleMobile"%>
<%@page import="com.gang.entity.article.Article"%>
<%@page import="com.gang.service.template.TemplateService"%>
<%@page import="com.gang.service.article.ArticleService"%>
<%@page import="com.gang.comms.SpringContextUtil"%>
<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://" + request.getServerName() + ":" + request.getServerPort() + path + "/";
	String layoutId=request.getParameter("layoutId");
	TemplateService templateService = (TemplateService) SpringContextUtil.getBean("TemplateService");
	String HTML=templateService.render(layoutId,basePath);
	response.getWriter().write(HTML);
%>
