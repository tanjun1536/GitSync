package com.gang.entity.article;

import java.util.Date;

import com.gang.entity.BaseEntity;
import com.gang.entity.user.FrontUser;

public class ArticleComment extends BaseEntity {
	/**
	 * 评论内容
	 */
	private String comments;
	/**
	 * 评论时间
	 */
	private Date commentDate;
	/**
	 * 评论人
	 */
	private FrontUser commentUser;

	/**
	 * 所属文章
	 */
	private Article article;

	public Article getArticle() {
		return article;
	}

	public void setArticle(Article article) {
		this.article = article;
	}


	public Date getCommentDate() {
		return commentDate;
	}

	public FrontUser getCommentUser() {
		return commentUser;
	}


	public String getComments() {
		return comments;
	}

	public void setComments(String comments) {
		this.comments = comments;
	}

	public void setCommentDate(Date commentDate) {
		this.commentDate = commentDate;
	}

	public void setCommentUser(FrontUser commentUser) {
		this.commentUser = commentUser;
	}
}
