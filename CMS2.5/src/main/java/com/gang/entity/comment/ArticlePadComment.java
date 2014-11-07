package com.gang.entity.comment;

import java.util.Date;

import com.gang.entity.BaseEntity;
import com.gang.entity.article.ArticlePad;
import com.gang.entity.user.FrontUser;
import com.google.gson.annotations.Expose;

/**
 * 手机文章评论
 * @author Administrator
 *
 */
public class ArticlePadComment extends BaseEntity{
	/**
	 * 通过
	 */
	public static final String AUDIT_PASS = "pass";
	/**
	 * 未通过
	 */
	public static final String AUDIT_NO_PASS = "nopass";
	/**
	 * 待审核
	 */
	public static final String AUDIT_ING = "ing";
	/**
	 * 不需要审核
	 */
	public static final String AUDIT_NONE = "none";
	/**
	 * 平板文章
	 */
	@Expose private ArticlePad article;
	/**
	 * 用户
	 */
	@Expose private FrontUser user;
	/**
	 * 标题
	 */
	private String title;
	/**
	 * 内容
	 */
	@Expose private String content;
	/**
	 * 发送时间
	 */
	@Expose private Date postDate;
	/**
	 * 审核状态
	 */
	private String auditStatus;
	public String getAuditStatus() {
		return auditStatus;
	}
	public void setAuditStatus(String auditStatus) {
		this.auditStatus = auditStatus;
	}
	public ArticlePad getArticle() {
		return article;
	}
	public void setArticle(ArticlePad article) {
		this.article = article;
	}
	public FrontUser getUser() {
		return user;
	}
	public void setUser(FrontUser user) {
		this.user = user;
	}
	public String getTitle() {
		return title;
	}
	public void setTitle(String title) {
		this.title = title;
	}
	public String getContent() {
		return content;
	}
	public void setContent(String content) {
		this.content = content;
	}
	public Date getPostDate() {
		return postDate;
	}
	public void setPostDate(Date postDate) {
		this.postDate = postDate;
	}
}
