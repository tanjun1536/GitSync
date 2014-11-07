package com.gang.filter;

import java.io.IOException;

import javax.servlet.Filter;
import javax.servlet.FilterChain;
import javax.servlet.FilterConfig;
import javax.servlet.ServletException;
import javax.servlet.ServletRequest;
import javax.servlet.ServletResponse;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.gang.entity.user.BackUser;

public class SessionFilter implements Filter {

	@Override
	public void destroy() {
	}

	@Override
	public void doFilter(ServletRequest request, ServletResponse response, FilterChain chain) throws IOException, ServletException {
		HttpServletRequest req = (HttpServletRequest) request;
		HttpServletResponse rep = (HttpServletResponse) response;
		BackUser currentLoginUser = (BackUser) req.getSession().getAttribute("BackLoginUser");
		if (req.getRequestURI().endsWith("login.jsp")
				||req.getRequestURI().endsWith("LoginAction.action")
				||req.getRequestURI().endsWith("register.jsp")
				||req.getRequestURI().endsWith("registerforpad.jsp")
				||req.getRequestURI().endsWith("ArticleMobileComment.jsp")
				||req.getRequestURI().endsWith("ArticlePadComment.jsp")
				||req.getRequestURI().endsWith("register.action")
				||req.getRequestURI().contains("ArticlePadCommentAction")
				||req.getRequestURI().contains("ArticleMobileCommentAction")
				||req.getRequestURI().contains("PM25Action")
				||req.getRequestURI().contains("FeedBackAction")
				||req.getRequestURI().contains("ShareAction")
				||req.getRequestURI().contains("ExposeAction")
				||req.getRequestURI().contains("TaskServiceAction")
				||req.getRequestURI().contains("TradeServiceAction")
				||req.getRequestURI().contains("UserServiceAction")
				||req.getRequestURI().contains("CMSServiceAction")
				||req.getRequestURI().endsWith("feedback.jsp")
				||req.getRequestURI().endsWith("next.jsp")
				||req.getRequestURI().endsWith("feedbackforpad.jsp")
				||req.getRequestURI().endsWith("changepassword.jsp")
				||req.getRequestURI().endsWith("changepasswordsuccess.jsp")
				||req.getRequestURI().endsWith("forgetpassword.jsp")
				||req.getRequestURI().endsWith("forgetpasswordsuccess.jsp")
				) {
			chain.doFilter(req, rep);
		} else {
			if (currentLoginUser == null) {
				rep.sendRedirect(req.getContextPath() + "/jsp/index/login.jsp");
			}
			else
			{
				chain.doFilter(req, rep);
			}
		}
	}

	@Override
	public void init(FilterConfig arg0) throws ServletException {
	}
}
