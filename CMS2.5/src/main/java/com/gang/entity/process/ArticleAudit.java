package com.gang.entity.process;

import java.io.Serializable;
import java.util.Date;

import com.gang.entity.BaseEntity;
import com.gang.entity.article.ArticleMobile;
import com.google.gson.annotations.Expose;

public class ArticleAudit extends BaseEntity implements Serializable{
	
	private static final long serialVersionUID = 1L;
	//审核人编号
	private Integer userId;
	//审核人
	@Expose
	private String userName;
	//审核时间
	@Expose
	private Date auditDate;
	//退回原因
	@Expose
	private String reason;
	//审核状态
	@Expose
	private State state;
	//审核文章
	private ArticleMobile article;
	public ArticleMobile getArticle() {
		return article;
	}
	public void setArticle(ArticleMobile article) {
		this.article = article;
	}
	public static long getSerialVersionUID() {
		return serialVersionUID;
	}
	public Integer getUserId() {
		return userId;
	}
	public void setUserId(Integer userId) {
		this.userId = userId;
	}
	public String getUserName() {
		return userName;
	}
	public void setUserName(String userName) {
		this.userName = userName;
	}
	public Date getAuditDate() {
		return auditDate;
	}
	public void setAuditDate(Date auditDate) {
		this.auditDate = auditDate;
	}
	public String getReason() {
		return reason;
	}
	public void setReason(String reason) {
		this.reason = reason;
	}
	public State getState() {
		return state;
	}
	public void setState(State state) {
		this.state = state;
	}
}
