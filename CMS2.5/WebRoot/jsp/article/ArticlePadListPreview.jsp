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
	String S=request.getParameter("S");
	String templateId=request.getParameter("templateId");
	TemplateService templateService = (TemplateService) SpringContextUtil.getBean("TemplateService");
	String HTML=templateService.render(S,templateId,basePath);
	response.getWriter().write(HTML);
%>
