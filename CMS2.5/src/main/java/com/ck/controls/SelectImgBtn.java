package com.ck.controls;

import java.io.IOException;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.jsp.JspException;
import javax.servlet.jsp.JspWriter;
import javax.servlet.jsp.tagext.TagSupport;

public class SelectImgBtn extends TagSupport {
	private static final long serialVersionUID = 1L;

	@Override
	public int doStartTag() throws JspException {
		JspWriter out=pageContext.getOut();   
		HttpServletRequest request = ((HttpServletRequest)pageContext.getRequest());
		String path = request.getContextPath();
		String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
		try {
			out.println("<script>if(window.ck == null){document.write('<script type=\"text/javascript\" src=\"" + basePath +"jsp/img/ck.js\"><\\/script>')};</script>");
			out.println("<input type='button' onClick='window.ck.h()' value='浏览' />");
		} catch (IOException e) {
			e.printStackTrace();
		}
		return EVAL_PAGE;
	}

	@Override
	public int doEndTag() throws JspException {
		return super.doEndTag();
	}
}
