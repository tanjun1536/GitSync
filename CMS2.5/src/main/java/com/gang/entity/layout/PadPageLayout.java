package com.gang.entity.layout;

import java.util.Date;
import java.util.Set;

import com.gang.entity.BaseEntity;
import com.gang.entity.article.Article;
import com.gang.entity.template.Template;
import com.gang.entity.user.BackUser;
import com.google.gson.annotations.Expose;

public class PadPageLayout extends BaseEntity {
	/**
	 * 包涵的文章
	 */
	private Set<PadPageLayoutArticle> articles;

	/**
	 * 创建时间
	 */
	@Expose
	private Date createDate=new Date();

	/**
	 * 创建人
	 */
	private BackUser createUser;
	/**
	 * 域名
	 */
	private String domain;

	/**
	 * 连接
	 */
	private String link;
	/**
	 * 所属栏目
	 */
	private Integer section;
	/**
	 * 状态 是否发布
	 */
	@Expose
	private Integer state=0;
	/**
	 * 版面模版
	 */
	private Template template;
	
	/**
	 * 版面标题
	 */
	@Expose
	private String title;
	/**
	 * 修改时间
	 */
	private Date updateDate;
	
	/**
	 * 修改人
	 */
	private BackUser updateUser;

	public Set<PadPageLayoutArticle> getArticles() {
		return articles;
	}

	public Date getCreateDate() {
		return createDate;
	}

	public BackUser getCreateUser() {
		return createUser;
	}

	public String getDomain() {
		return domain;
	}

	public String getLink() {
		return link;
	}

	public Integer getSection() {
		return section;
	}
	
	public Integer getState() {
		return state;
	}
	
	public Template getTemplate() {
		return template;
	}
	
	public String getTitle() {
		return title;
	}
	public Date getUpdateDate() {
		return updateDate;
	}
	public BackUser getUpdateUser() {
		return updateUser;
	}
	public void setArticles(Set<PadPageLayoutArticle> articles) {
		this.articles = articles;
	}
	public void setCreateDate(Date createDate) {
		this.createDate = createDate;
	}

	public void setCreateUser(BackUser createUser) {
		this.createUser = createUser;
	}

	public void setDomain(String domain) {
		this.domain = domain;
	}

	public void setLink(String link) {
		this.link = link;
	}

	public void setSection(Integer section) {
		this.section = section;
	}

	public void setState(Integer state) {
		this.state = state;
	}

	public void setTemplate(Template template) {
		this.template = template;
	}

	public void setTitle(String title) {
		this.title = title;
	}

	public void setUpdateDate(Date updateDate) {
		this.updateDate = updateDate;
	}

	public void setUpdateUser(BackUser updateUser) {
		this.updateUser = updateUser;
	}
}
