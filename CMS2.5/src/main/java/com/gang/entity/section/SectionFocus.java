package com.gang.entity.section;

import java.util.Date;
import java.util.Set;

import com.gang.entity.BaseEntity;
import com.gang.entity.article.ArticleMobile;
import com.gang.entity.process.SectionFocusAudit;
import com.gang.entity.process.State;
import com.google.gson.annotations.Expose;

public class SectionFocus extends BaseEntity {

	/**
	 * 栏目
	 */
	@Expose
	private Section section;
	/**
	 * 焦点图片
	 */
	private String imagePath;

	/**
	 * 焦点的连接
	 */
	@Expose
	private String focusLink;


	/**
	 * 标题
	 */
	@Expose
	private String title;

	/**
	 * 内容
	 */
	private String content;

	/**
	 * 关联文章
	 */
	private ArticleMobile article;
	
	/**
	 * 状态
	 */
	@Expose
	private State state;
	
	/**
	 * 置顶时间
	 */
	private Date topDate=new Date();
	
	/**
	 * 发布时间
	 */
	private Date distributeDate;
	
	private Integer version;
	
	public Integer getVersion() {
		return version;
	}

	public void setVersion(Integer version) {
		this.version = version;
	}

	public Date getDistributeDate() {
		return distributeDate;
	}

	public void setDistributeDate(Date distributeDate) {
		this.distributeDate = distributeDate;
	}

	public Date getTopDate() {
		return topDate;
	}

	public void setTopDate(Date topDate) {
		this.topDate = topDate;
	}

	private Set<SectionFocusAudit> autits;
	

	public Set<SectionFocusAudit> getAutits() {
		return autits;
	}

	public void setAutits(Set<SectionFocusAudit> autits) {
		this.autits = autits;
	}

	private String linkAddress;

	public String getLinkAddress() {
		return linkAddress;
	}

	public void setLinkAddress(String linkAddress) {
		this.linkAddress = linkAddress;
	}

	public State getState() {
		return state;
	}

	public void setState(State state) {
		this.state = state;
	}

	public ArticleMobile getArticle() {
		return article;
	}

	public void setArticle(ArticleMobile article) {
		this.article = article;
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
	public String getFocusLink() {
		return focusLink;
	}

	public void setFocusLink(String focusLink) {
		this.focusLink = focusLink;
	}

	public Section getSection() {
		return section;
	}

	public void setSection(Section section) {
		this.section = section;
	}

	public String getImagePath() {
		return imagePath;
	}

	public void setImagePath(String imagePath) {
		this.imagePath = imagePath;
	}

}
