package com.gang.entity.article;

public class ArticlePadLayout extends ArticlePad {
	private Integer pageId;
	private Integer index;
	private Integer pageStyle;

	public ArticlePadLayout(Article article) {
		this.setId(article.getId());
		this.setTitle(article.getTitle());
		this.setContentLink(article.getContentLink());
		this.setCreateDate(article.getCreateDate());
		this.setTopDate(article.getTopDate());
		this.setFocusImage(article.getFocusImage());
		this.setTitleImage(article.getTitleImage());
		this.setSubTitle(article.getSubTitle());
		this.setDomain(article.getDomain());
		this.setSource(article.getSource());
		this.setContent(article.getContent());
		this.setEditor(article.getEditor());
		this.setState(article.getState());
		this.setTemplate(article.getTemplate());
		this.setBrowseCount(article.getBrowseCount());
		this.setIsHot(article.getIsHot());
		this.setSender(article.getSender());
		this.setSection(article.getSection());
		this.setSummary(article.getSummary());
		this.setDistributeDate(article.getDistributeDate());

	}

	public Integer getPageId() {
		return pageId;
	}

	public void setPageId(Integer pageId) {
		this.pageId = pageId;
	}

	public Integer getIndex() {
		return index;
	}

	public void setIndex(Integer index) {
		this.index = index;
	}

	public Integer getPageStyle() {
		return pageStyle;
	}

	public void setPageStyle(Integer pageStyle) {
		this.pageStyle = pageStyle;
	}

}
