<%@page import="com.gang.entity.imagecontent.ImageContent"%>
<%@page import="com.gang.entity.imagecontent.PadImageContent"%>
<%@page import="com.gang.entity.article.ArticlePad"%>
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
	String articleId = request.getParameter("articleId");
	String type = request.getParameter("type");
	Class clazz = null;
	if ("pad".equals(type))
		clazz = ArticlePad.class;
	else if ("padImage".equals(type))
		clazz = PadImageContent.class;
	else if ("mobile".equals(type))
		clazz = ArticleMobile.class;
	else if ("mobileImage".equals(type))
		clazz = ImageContent.class;
	TemplateService templateService = (TemplateService) SpringContextUtil.getBean("TemplateService");
	String HTML = templateService.render(Integer.parseInt(articleId), clazz, basePath);
	response.getWriter().write(HTML);
%>
