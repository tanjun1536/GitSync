package com.gang.action.comment;

import java.util.Date;

import com.gang.action.BaseAction;
import com.gang.action.DefaultAction;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.comment.ArticleMobileComment;
import com.gang.service.comment.ArticleMobileCommentService;

public class ArticleMobileCommentAction extends DefaultAction {

	private ArticleMobileCommentService service;
	private ArticleMobileComment comment;
	public ArticleMobileComment getComment() {
		return comment;
	}

	public void setComment(ArticleMobileComment comment) {
		this.comment = comment;
	}

	public void setService(ArticleMobileCommentService service) {
		this.service = service;
	}
	@Override
	public void getList() throws Exception {
		Write(service.getDoAuditComments(new GridPageRequest(getRequest())));
	}
	public void getComments() throws Exception {
		GridPageRequest gr = new GridPageRequest(getRequest());
		StringBuffer csql = new StringBuffer(" SELECT count(c) FROM ArticleMobileComment c WHERE c.article.id="+getId());
		StringBuffer dsql = new StringBuffer(" SELECT c FROM ArticleMobileComment c WHERE c.article.id="+getId());
		gr.setHsql(true);
		gr.setTableAlias("c");
		gr.setCsql(csql.toString());
		gr.setDsql(dsql.toString());
		gr.setClazz(ArticleMobileComment.class);
		GridPageResponse gpr = service.getGridPage(gr);
		String json = JSONHelper.SerializeWithNeedAnnotation(gpr);
		Write(json);
	}

	@Override
	public String save() throws Exception {
		comment.setPostDate(new Date());
		service.add(comment);
		String path = "ArticleMobileCommentAction!comments.action?id=" + getRequest().getParameter("id") +"&page=" + getRequest().getParameter("page") + "&rows=" + getRequest().getParameter("rows") + "&userId=" + getRequest().getParameter("userId");
		getResponse().sendRedirect(path);
		return NONE;
	}
	
	/**
	 * 查询评论
	 * @return
	 */
	public String comments() throws Exception{
		GridPageResponse gpr = service.getComments(getId(), new GridPageRequest(getRequest()));
		getRequest().setAttribute("gpr", gpr);
		return SUCCESS;
	}
	
	/**
	 * 查询待审核评论
	 * @return
	 */
	public void auditcomments() throws Exception{
		Write(service.getAuditComments(getId(), new GridPageRequest(getRequest())));
	}

	public void pass() throws Exception{
		service.changeStatus(getString("ids").split(","), ArticleMobileComment.AUDIT_PASS);
		String path = "jsp/comments/ArticleMobileCommentAuditList.jsp";
		getResponse().sendRedirect(path);
	}
	
	public void nopass() throws Exception{
		service.changeStatus(getString("ids").split(","), ArticleMobileComment.AUDIT_NO_PASS);
		String path = "jsp/comments/ArticleMobileCommentAuditList.jsp";
		getResponse().sendRedirect(path);
	}
	public ArticleMobileCommentAction() {
		// TODO Auto-generated constructor stub
	}

	@Override
	public void ajaxDelete(Integer id) throws Exception {
		// TODO Auto-generated method stub
		service.delete(ArticleMobileComment.class, id);
	}
	
}
