package com.gang.entity.section;

import java.util.Date;
import java.util.Set;

import com.gang.entity.BaseEntity;
import com.gang.entity.article.ArticlePad;
import com.gang.entity.process.PadSectionFocusAudit;
import com.gang.entity.process.State;
import com.google.gson.annotations.Expose;


public class PadSectionFocus extends BaseEntity {
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
	private ArticlePad article;
	
	/**
	 * 状态
	 */
	@Expose
	private State state;
	
	private Date topDate=new Date();
	
	private Date distributeDate;
	
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

	/**
	 * 审核记录
	 */
	private Set<PadSectionFocusAudit> autits;
	
	public Set<PadSectionFocusAudit> getAutits() {
		return autits;
	}

	public void setAutits(Set<PadSectionFocusAudit> autits) {
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

	public ArticlePad getArticle() {
		return article;
	}

	public void setArticle(ArticlePad article) {
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
